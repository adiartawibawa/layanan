<div>
    <div id="mapThumbnail" class="w-[100px] h-[100px]" wire:ignore></div>
</div>

@assets
    <!-- Load D3.js -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
@endassets

@script
    <script>
        let meta = @json($meta);

        if (meta) {
            // Langsung gunakan data dari 'meta', tidak perlu memanggil d3.json(meta)
            let data = meta.geometry;

            let mapElement = document.getElementById('mapThumbnail');
            let width = mapElement.clientWidth;
            let height = mapElement.clientHeight;

            let projection = d3.geoEqualEarth().fitSize([width, height], data);
            let path = d3.geoPath().projection(projection);

            // Create an SVG element for the map
            let svg = d3.select("#mapThumbnail").append('svg')
                .attr("viewBox", `0 0 ${width} ${height}`)
                .attr("width", width)
                .attr("height", height)
                .style("max-width", "100%")
                .style("height", "auto");

            let g = svg.append("g");

            // Draw the polygons from the geometry data
            g.selectAll("path")
                .data(data.coordinates)
                .enter().append("path")
                .attr("d", function(d) {
                    return path({
                        "type": "MultiPolygon",
                        "coordinates": [d]
                    });
                })
                .attr("fill", "steelblue")
                .attr("stroke", "black")
                .attr("stroke-width", 0.5);

        } else {
            console.error("No geometry map found.");
        }
    </script>
@endscript
