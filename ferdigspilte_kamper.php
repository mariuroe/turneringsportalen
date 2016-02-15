<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<title></title>
</head>

<body>

<h1>Ferdigspilte Kamper</h1>
<div id="playedMatches"> </div>
<script type="text/javascript"> 
       
        var dsv = d3.dsv(";", "text/csv; charset=ISO-8859-1");
        
        dsv("statusfil.csv", function(datasetText) {
        
        // table showing result from played matches
        var table = d3.select("#playedMatches").append("table"),
            thead = table.append("thead"),
            tbody = table.append("tbody");


        var columns = ["Kamp",  "Kategori", "Navn1", "Navn2", "Resultat"];
        var columns2 = ["Kamp", "Klasse", "Motstander 1", "Motstander 2", "Resultat"];
        
        // append the header row
        thead.append("tr")
            .selectAll("th")
            .data(columns2)
            .enter()
            .append("th")
            .text(function(column) { return column; });
            
        var finishedMatches = datasetText.filter(function(row){return row["Resultat"]!="";});
        finishedMatches.reverse();
        
        // join "Kategori" and "Række" content into "Kategori"  to save space
        for (var i=0; i < finishedMatches.length ;i++) {
            finishedMatches[i]["Kategori"] += " " ;
            finishedMatches[i]["Kategori"] += finishedMatches[i]["Række"];
        }
            
        // create a row for each object in the data
        var rows = tbody.selectAll("tr")
            .data(finishedMatches)
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
