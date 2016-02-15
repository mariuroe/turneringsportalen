<?php error_reporting(-1); ?>
<?php
$url=$_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<style>table, th, td { font-size:117%; }</style>
<title>Live Sotra KM VEST/Sotra Open 2016</title>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>

<h1>Spillende kamper</h1>
<div id="activeMatches"> </div>

<section align="center" id="footer">
        		<header>
					<h2>Sponsorer:</h2>
				</header>

			<div class="copyright">
				<ul class="menu">
					
                    <a href="http://www.spv.no" target="_blank">
                    <img src="images/spv.png" alt="Sparebanken Vest" />
                    </a>
                   <a href="http://www.arntsen.no/" target="_blank">
                   <img src="images/arntsen.png" alt="Arntsen" />
                   </a>
                   <a href="http://www.ccb.no/" target="_blank">
                   <img src="images/ccb.png" alt="Coast Center Base" />
                   </a>
                   <a href="http://www.mot.no/" target="_blank">
                   <img src="images/mot.png" alt="MOT" />
                   </a>
                    
				</ul>
			</div>
		</section>


   <script type="text/javascript"> 
   
       function stringCompare1(a, b) {
            var ia = parseInt(a);
            var ib = parseInt(b);
            return ia > ib ? 1 : ia == ib ? 0 : -1;
        }
    
        var dsv = d3.dsv(";", "text/csv; charset=ISO-8859-1");
        
        dsv("statusfil.csv", function(datasetText) {
        
        var columns = ["Bane", "Kamp", "Kategori", "Navn1", "Navn2"];
        var columns2 = ["Bane", "Kamp", "Klasse", "Motstander 1", "Motstander 2"];


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
            
        
        var activeMatches = datasetText.filter(function(row){return row["Status"]=="I gang";});
        var sortedActive = activeMatches.sort(function (a, b) { return a == null || b == null ? 0 : stringCompare1(a["Bane"], b["Bane"]); });

        // join "Kategori" and "Række" content into "Kategori"  to save space
        for (var i=0; i < sortedActive.length ;i++) {
            sortedActive[i]["Kategori"] += " " ;
            sortedActive[i]["Kategori"] += sortedActive[i]["Række"];
        }

        // create a row for each object in the data
        var rows = tbody.selectAll("tr")
            .data(sortedActive)
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
    
    </script>
</body>
</html>
