<div>
    <div id="map" class="w-full h-[650px]" wire:ignore></div>
</div>

@assets
    <!-- Load D3.js -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
@endassets

@script
    <script>
        document.addEventListener("livewire:initialized", function() {
            var url = @json(\App\Models\MapHistory::getActiveWilayahMapUrl());

            if (url) {
                d3.json(url).then(function(data) {
                    // Get the map container size
                    var mapElement = document.getElementById('map');
                    var width = mapElement.clientWidth;
                    var height = mapElement.clientHeight;

                    // Set up map projection and path generator
                    var projection = d3.geoEqualEarth().fitSize([width, height], data);
                    var path = d3.geoPath().projection(projection);

                    // Create an SVG element for the map
                    var svg = d3.select("#map").append('svg')
                        .attr("viewBox", `0 0 ${width} ${height}`)
                        .attr("width", width)
                        .attr("height", height)
                        .style("max-width", "100%")
                        .style("height", "auto");

                    var g = svg.append("g"); // Group element for the map

                    // Create floating text in the top-left corner to display region information
                    var infoText = svg.append("text")
                        .attr("x", 10)
                        .attr("y", 30)
                        .attr("id", "floating-info")
                        .attr("font-size", "14px")
                        .attr("font-weight", "bold")
                        .attr("fill", "#000")
                        .style("display", "none"); // Initially hidden

                    // Define colors for different regions (kecamatan)
                    var kecamatanColors = {
                        "KUTA SELATAN": "#1fdce5",
                        "KUTA": "#37e7d3",
                        "KUTA UTARA": "#66f0bb",
                        "MENGWI": "#96f69f",
                        "ABIANSEMAL": "#c7f984",
                        "PETANG": "#f9f871"
                    };

                    // Add regions (features) to the map using GeoJSON data
                    var features = g.selectAll("path")
                        .data(data.features)
                        .enter().append("path")
                        .attr("fill", d => kecamatanColors[d.properties.kecamatan_name] ||
                            "#088") // Set region color
                        .attr("stroke", "#000") // Set border color
                        .attr("d", path) // Define the path for each region
                        .attr("cursor", "pointer") // Set cursor style to pointer
                        .style("opacity", 1)
                        .on("click", clickedRegion) // Click event to zoom on the region
                        .on("mouseover", function(event, d) {
                            d3.select(this).transition().duration(300).attr("fill",
                                "#FF0000"); // Highlight on hover
                            // Display floating region info
                            infoText.style("display", "block")
                                .text(
                                    `Desa: ${d.properties.desa_name}, Kecamatan: ${d.properties.kecamatan_name}`
                                )
                                .attr("x", event.pageX) // Posisi info text sesuai dengan posisi mouse
                                .attr("y", event.pageY - 10); // Sedikit di atas mouse
                        })
                        .on("mouseout", function(event, d) {
                            d3.select(this).transition().duration(300).attr("fill", d =>
                                kecamatanColors[d.properties.kecamatan_name] || "#088"
                            ); // Reset color on mouse out
                            // Sembunyikan floating info
                            infoText.style("display", "none");
                        });

                    // Define zoom behavior and call it on the SVG
                    var zoom = d3.zoom().scaleExtent([1, 8]).on("zoom", zoomed);
                    svg.call(zoom);

                    var active = null;

                    // Function to reset the map to its original state (zoom out)
                    function reset() {
                        if (active) {
                            features.transition().duration(500).style("opacity", 1); // Show all regions
                            svg.transition().duration(1000).call(
                                zoom.transform,
                                d3.zoomIdentity, // Reset zoom
                                d3.zoomTransform(svg.node()).invert([width / 2, height / 2])
                            );
                            d3.selectAll("image").remove(); // Remove all points
                            active = null;

                            // Hide the floating info text
                            infoText.style("display", "none");
                        }
                    }

                    // Function that handles the region click event
                    function clickedRegion(event, d) {
                        event.stopPropagation();

                        if (active === this) {
                            return reset();
                        }

                        active = this;

                        // Set opacity for the clicked region and hide others
                        features.transition().duration(500)
                            .style("opacity", function() {
                                return this === active ? 1 : 0;
                            });

                        // Get the bounds (bounding box) of the clicked region
                        const [
                            [x0, y0],
                            [x1, y1]
                        ] = path.bounds(d);

                        // Calculate region and canvas dimensions
                        const regionWidth = x1 - x0;
                        const regionHeight = y1 - y0;
                        const canvasWidth = width;
                        const canvasHeight = height;

                        // Calculate the zoom scale to ensure the region fills 80% of the canvas
                        const scale = Math.min(0.9 / Math.max(regionWidth / canvasWidth, regionHeight /
                            canvasHeight));

                        // Apply the zoom transformation to center the region
                        svg.transition().duration(1000).call(
                            zoom.transform,
                            d3.zoomIdentity.translate(canvasWidth / 2, canvasHeight / 2)
                            .scale(scale)
                            .translate(-(x0 + x1) / 2, -(y0 + y1) / 2)
                        );

                        // Display floating region info
                        infoText.style("display", "block")
                            // .attr("class", "rounded-lg bg-red-500 px-8 py-10 text-white")
                            .text(
                                `Desa: ${d.properties.desa_name}, Kecamatan: ${d.properties.kecamatan_name}`
                            );

                        // Load points (schools) for the selected region
                        $wire.dispatch('loadPoints', {
                            desaCode: d.properties.desa_code
                        });
                    }

                    // Handle points (schools) loading event
                    $wire.on('pointsLoaded', (event) => {
                        var points = JSON.parse(event); // Parse the points data
                        var pointsLayer = g.append("g"); // Add a new group for points

                        pointsLayer.selectAll("image").remove(); // Remove existing points (if any)
                        pointsLayer.selectAll("image")
                            .data(points.features)
                            .enter().append("image")
                            .attr("xlink:href", function(d) {
                                // Ambil URL ikon berdasarkan bentuk sekolah
                                return "{{ asset('icon/school-' . strtolower(':bentuk_code') . '.png') }}"
                                    .replace(':bentuk_code', d.properties.bentuk_code
                                        .toLowerCase());
                            })
                            .attr("x", function(d) {
                                return projection([d.geometry.coordinates[0], d.geometry
                                    .coordinates[1]
                                ])[0] - 6;
                            })
                            .attr("y", function(d) {
                                return projection([d.geometry.coordinates[0], d.geometry
                                    .coordinates[1]
                                ])[1] - 6;
                            })
                            .attr("width", 6) // Sesuaikan ukuran ikon
                            .attr("height", 6) // Sesuaikan ukuran ikon
                            .attr("cursor", "pointer") // Change cursor to hand on hover
                            .on("mouseover", function(event, d) {
                                d3.select(this)
                                    .transition()
                                    .duration(200)
                                    .attr("width", 12) // Perbesar ikon pada hover
                                    .attr("height", 12); // Perbesar ikon pada hover
                            })
                            .on("mouseout", function(event, d) {
                                d3.select(this)
                                    .transition()
                                    .duration(200)
                                    .attr("width", 6) // Kembalikan ukuran ikon semula
                                    .attr("height", 6); // Kembalikan ukuran ikon semula
                            })
                            .on("click", function(event, d) {
                                console.log(d);

                                showPointPopup(event, d
                                    .properties); // Panggil fungsi untuk menampilkan popup
                            });
                    });

                    // Function to show a popup with point information
                    function showPointPopup(event, properties) {
                        d3.select("#info-popup").remove(); // Remove existing popup

                        // Create and position the new popup
                        var popup = d3.select("body").append("div")
                            .attr("id", "info-popup")
                            .style("position", "absolute")
                            .style("background", "white")
                            .style("border", "1px solid #ccc")
                            .style("padding", "10px")
                            .style("left", (event.pageX + 10) + "px")
                            .style("top", (event.pageY + 10) + "px")
                            .style("border-radius", "5px");

                        // Add content to the popup
                        popup.append("h4")
                            .attr("class", "font-bold text-lg mb-2 text-gray-800")
                            .text("Informasi Sekolah");
                        popup.append("p")
                            .attr("class", "text-sm text-gray-700 mb-1")
                            .text(`Nama: ${properties.nama}`);
                        popup.append("p")
                            .attr("class", "text-sm text-gray-700 mb-1")
                            .text(`Bentuk: ${properties.bentuk}`);
                        popup.append("p")
                            .attr("class", "text-sm text-gray-700 mb-4")
                            .text(`Jumlah Pegawai: ${properties.pegawai_count}`);

                        // Add a detail link button
                        popup.append("a")
                            .attr("href",
                                `/sekolah/${properties.npsn}/detail`
                            ) // Link to the detail page using the `npsn`
                            .attr("class",
                                "inline-block bg-blue-500 text-white font-semibold py-1 px-2 rounded hover:bg-blue-600 transition duration-300"
                            )
                            .attr("target", '_blank')
                            .text("View Details");

                        // Add close button with Tailwind styling
                        popup.append("button")
                            .attr("class",
                                "ml-4 inline-block bg-primary text-white font-semibold py-1 px-2 rounded hover:bg-red-600 transition duration-300"
                            )
                            .text("Close")
                            .on("click", function() {
                                d3.select("#info-popup").remove(); // Close the popup on click
                            });

                    }

                    // Zoom handler function
                    function zoomed(event) {
                        const {
                            transform
                        } = event;
                        g.attr("transform", transform); // Apply zoom transformation
                        g.attr("stroke-width", 1 / transform
                            .k); // Adjust stroke width based on zoom level
                    }
                }).catch(function(error) {
                    console.error("Error loading the GeoJSON data: ",
                        error); // Log error if loading fails
                });
            } else {
                console.error("No active wilayah map found."); // Log error if no active map URL is found
            }
        });
    </script>
@endscript
