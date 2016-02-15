<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<title></title>
</head>

<body>
<h1>Søk på spillerens fornavn/etternavn</h1>
<p id="dag">
Kampnr. xx spilles lørdag <br />
Kampnr. xx spilles søndag
</p>

<div id="playedMatches"> </div>

        <script>
        function stringCompare1(a, b) {
            var ia = parseInt(a);
            var ib = parseInt(b);
            return ia > ib ? 1 : ia == ib ? 0 : -1;
        }
    
        function stringCompare2(a, b) {
           var ia = parseInt(a);
           var ib = parseInt(b);            
           return ia-ib;
        }
        
        function renderPage() {
            var dsv = d3.dsv(";", "text/csv; charset=ISO-8859-1");
            
            dsv("statusfil.csv", function(datasetText) {
            
            var sokefelt = document.getElementById("fsok");
            var sokeord  = sokefelt.value.toLowerCase();
          
            var columns = ["Kamp", "Tid", "Kategori", "Navn1", "Navn2", "Resultat"];
            var columns2 = ["Kamp", "Tid", "Klasse", "Motstander 1", "Motstander 2", "Resultat"];

            document.getElementById("activeMatches").innerHTML = "";

            // table showing matces beeing played
            var table = d3.select("#activeMatches").append("table"),
                thead = table.append("thead"),
                tbody = table.append("tbody");

            // append the header row
            thead.append("tr")
                .selectAll("th")
                .data(columns2)
                .enter()
                .append("th")
                .text(function(column) { return column; });
            
            var activeMatches = datasetText.filter(
                function(row){
                    var A = row["Navn1"].toLowerCase();
                    var B = row["Navn2"].toLowerCase();
                    return A.indexOf(sokeord)>-1 ||B.indexOf(sokeord)>-1;
                }
            );
            
            // join "Kategori" and "Række" content into "Kategori"  to save space
            for (var i=0; i < activeMatches.length ;i++) {
                activeMatches[i]["Kategori"] += " " ;
                activeMatches[i]["Kategori"] += activeMatches[i]["Række"];
            }

            // create a row for each object in the data
            var rows = tbody.selectAll("tr")
                .data(activeMatches)
                .enter()
                .append("tr");

            // create a cell in each row for each column
            var cells = rows.selectAll("td")
                .data(function(row) {
                    return columns.map(function(column) {
                        return {column: column, value: row[column]};
                    });
                })
                .enter()
                .append("td")
                .text(function(d) { return d.value; });
                     
            });
        }
        
        renderPage();     
        </script>
<div style="text-align:center">
<form onsubmit="return false;" >
Søkeord: <input type="text" id="fsok" onkeydown="renderPage()">
</form>
</div>

<br>

<div id="activeMatches"> </div>  

</body>
</html>
