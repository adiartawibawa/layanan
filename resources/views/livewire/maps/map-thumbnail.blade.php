<div>
    <div id="mapThumbnail-{{ $id }}" class="map-thumbnail w-[100px] h-[100px]"></div>
</div>

@assets
    <!-- Load D3.js -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
@endassets

@script
    <script>
        let meta = @json($meta);
        let id = @js($id);

        if (meta && meta.geometry && meta.geometry.coordinates) {
            // Ambil data geometry dari 'meta'
            let data = meta.geometry;

            let mapElement = document.getElementById(`mapThumbnail-${id}`);
            let width = mapElement.clientWidth;
            let height = mapElement.clientHeight;

            // Buat proyeksi peta sesuai dengan elemen yang diinginkan
            let projection = d3.geoEqualEarth().fitSize([width, height], {
                type: data.type,
                coordinates: data.coordinates
            });
            let path = d3.geoPath().projection(projection);

            // Buat elemen SVG untuk menampilkan peta
            let svg = d3.select(`#mapThumbnail-${id}`).append('svg')
                .attr("viewBox", `0 0 ${width} ${height}`)
                .attr("width", width)
                .attr("height", height)
                .style("max-width", "100%")
                .style("height", "auto");

            let g = svg.append("g");

            // Pastikan tipe geometri adalah MultiPolygon atau Polygon
            let geometryType = data.type;

            if (geometryType === "MultiPolygon" || geometryType === "Polygon") {
                // Gambarkan path untuk setiap polygon
                g.selectAll("path")
                    .data(data.coordinates)
                    .enter().append("path")
                    .attr("d", function(d) {
                        // Jika Polygon, langsung gunakan koordinatnya
                        if (geometryType === "Polygon") {
                            return path({
                                "type": "Polygon",
                                "coordinates": d
                            });
                        }
                        // Jika MultiPolygon, koordinat harus dalam array tambahan
                        return path({
                            "type": "MultiPolygon",
                            "coordinates": [d]
                        });
                    })
                    .attr("fill", "steelblue")
                    .attr("stroke", "black")
                    .attr("stroke-width", 0.5);
            } else {
                console.error("Unsupported geometry type: " + geometryType);
            }
        } else {
            console.error("No valid geometry map found.");
        }
    </script>
@endscript
