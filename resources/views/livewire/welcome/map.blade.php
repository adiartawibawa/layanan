<div>
    <div id="map" class="w-full h-96"></div>
</div>

@push('scripts')
    <!-- Load D3.js -->
    <script src="https://d3js.org/d3.v7.min.js"></script>

    {{-- @livewireScripts --}}

    <script>
        document.addEventListener("livewire:initialized", function() {
            var url = @json(\App\Models\MapHistory::getActiveWilayahMapUrl());

            if (url) {
                // Load the GeoJSON data
                d3.json(url).then(function(data) {
                    var mapElement = document.getElementById('map');
                    var width = mapElement.clientWidth;
                    var height = mapElement.clientHeight;

                    // Set up the projection for the map, using Equal Earth projection
                    var projection = d3.geoEqualEarth().fitSize([width, height], data);

                    // Define a path generator using the projection
                    var path = d3.geoPath().projection(projection);

                    // Create the SVG canvas for the map
                    var svg = d3.select("#map").append('svg')
                        .attr("viewBox", `0 0 ${width} ${height}`)
                        .attr("width", width)
                        .attr("height", height)
                        .style("max-width", "100%")
                        .style("height", "auto");

                    // Create a group for the map features (regions)
                    var g = svg.append("g");

                    // Define static colors for each region
                    var kecamatanColors = {
                        "KUTA SELATAN": "#FF5733",
                        "KUTA": "#33FF57",
                        "KUTA UTARA": "#3357FF",
                        "MENGWI": "#FF33A1",
                        "ABIANSEMAL": "#FF8C33",
                        "PETANG": "#33FFF5"
                    };

                    // Draw the regions (districts)
                    var features = g.selectAll("path")
                        .data(data.features)
                        .enter().append("path")
                        .attr("fill", d => kecamatanColors[d.properties.kecamatan_name] || "#088")
                        .attr("stroke", "#000")
                        .attr("d", path)
                        .attr("cursor", "pointer")
                        .style("opacity", 1)
                        .on("click", clicked)
                        .on("mouseover", function(event, d) {
                            d3.select(this).transition().duration(300).attr("fill", "#FF0000");
                        })
                        .on("mouseout", function(event, d) {
                            d3.select(this).transition().duration(300).attr("fill", d =>
                                kecamatanColors[d.properties.kecamatan_name] || "#088");
                        });

                    // Add tooltips with district names
                    features.append("title").text(d => d.properties.desa_name);

                    // Set up zoom functionality
                    var zoom = d3.zoom()
                        .scaleExtent([1, 8])
                        .on("zoom", zoomed);

                    svg.call(zoom);

                    var active = null;

                    function reset() {
                        if (active) {
                            features.transition().duration(500).style("opacity", 1);

                            svg.transition().duration(1000).call(
                                zoom.transform,
                                d3.zoomIdentity,
                                d3.zoomTransform(svg.node()).invert([width / 2, height / 2])
                            );

                            d3.select("#info-popup").remove();
                            active = null;
                        }
                    }

                    function clicked(event, d) {
                        event.stopPropagation();

                        if (active === this) {
                            return reset();
                        }

                        active = this;

                        features.transition().duration(500)
                            .style("opacity", function() {
                                return this === active ? 1 : 0;
                            });

                        const [
                            [x0, y0],
                            [x1, y1]
                        ] = path.bounds(d);

                        svg.transition().duration(1000).call(
                            zoom.transform,
                            d3.zoomIdentity
                            .translate(width / 2, height / 2)
                            .scale(Math.min(8, 0.9 / Math.max((x1 - x0) / width, (y1 - y0) / height)))
                            .translate(-(x0 + x1) / 2, -(y0 + y1) / 2),
                            d3.pointer(event, svg.node())
                        );

                        Livewire.dispatch('loadPoints', {
                            desaCode: d.properties.desa_code
                        });

                        showInfoPopup(event, d.properties);
                    }

                    // Listen for the Livewire event with points data
                    Livewire.on('pointsLoaded', (event) => {
                        var points = JSON.parse(event);

                        console.log(points);

                        var pointsLayer = features.append("g").attr("class", "points-layer");

                        // // Clear old points before adding new ones
                        pointsLayer.selectAll("circle").remove();

                        pointsLayer.selectAll("circle")
                            .data(points.features)
                            .enter()
                            .append("circle")
                            .attr("cx", function(d) {
                                return projection([d.geometry.coordinates[0], d.geometry
                                    .coordinates[1]
                                ])[0];
                            })
                            .attr("cy", function(d) {
                                return projection([d.geometry.coordinates[0], d.geometry
                                    .coordinates[1]
                                ])[1];
                            })
                            .attr("r", 5)
                            .attr("fill", "blue")
                            .on("click", function(d) {
                                alert(
                                    `Sekolah: ${d.properties.name}\nBentuk: ${d.properties.bentuk}\nPegawai: ${d.properties.pegawai_count}`
                                );
                            });
                    });

                    function showInfoPopup(event, properties) {
                        d3.select("#info-popup").remove(); // Remove any existing popup

                        var popup = d3.select("body").append("div")
                            .attr("id", "info-popup")
                            .style("position", "absolute")
                            .style("background", "white")
                            .style("border", "1px solid #ccc")
                            .style("padding", "10px")
                            .style("box-shadow", "0 0 10px rgba(0,0,0,0.5)")
                            .style("left", (event.pageX + 10) + "px")
                            .style("top", (event.pageY + 10) + "px");

                        // Add the close button
                        popup.append("button")
                            .text("Close")
                            .style("float", "right")
                            .style("background", "#f44336")
                            .style("color", "white")
                            .style("border", "none")
                            .style("padding", "5px")
                            .style("cursor", "pointer")
                            .on("click", function() {
                                d3.select("#info-popup")
                                    .remove(); // Remove the popup when the button is clicked
                            });

                        popup.append("h4").text("Informasi Wilayah");
                        popup.append("p").text(`Code: ${properties.desa_code}`);
                        popup.append("p").text(`Desa: ${properties.desa_name}`);
                        popup.append("p").text(`Kecamatan: ${properties.kecamatan_name}`);
                        popup.append("p").text(`Kabupaten: ${properties.kabupaten_name}`);
                        popup.append("p").text(`Provinsi: ${properties.provinsi_name}`);
                    }


                    function zoomed(event) {
                        const {
                            transform
                        } = event;

                        // Apply zoom to the map
                        g.attr("transform", transform);
                        g.attr("stroke-width", 1 / transform.k);

                        // Ensure points are also transformed during zoom
                        d3.selectAll(".points-layer circle").attr("transform", transform);
                    }
                }).catch(function(error) {
                    console.error("Error loading the GeoJSON data: ", error);
                });
            } else {
                console.error("No active wilayah map found.");
            }
        });
    </script>
@endpush
