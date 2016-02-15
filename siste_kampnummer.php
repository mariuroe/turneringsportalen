<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<title></title>
</head>

<body>
<h1>Siste oppropte kamp</h1>
    <div id="lastCalledMatch"> </div>
   <script type="text/javascript"> 
   
       function stringCompare1(a, b) {
            var format = d3.time.format("%Y-%m-%d %H:%M:%S"); // 2015-01-24 09:03:58
            
            var d1 = format.parse(a);
            var d2 = format.parse(b);

            return d1 < d2 ? 1 : d1 == d2 ? 0 : -1;
        }
       
        function updateTable() {
            var dsv = d3.dsv(";", "text/csv; charset=ISO-8859-1");
            dsv("statusfil.csv", function(datasetText) {    
                var startedMatches = datasetText.filter(function(row){return row["Start"]!="";});
                var sortedByTime = startedMatches.sort(function (a, b) { return a == null || b == null ? 0 : stringCompare1(a["Start"], b["Start"]); });
                var lastCalled = sortedByTime.shift();

                document.getElementById("lastCalledMatch").innerHTML = lastCalled["Kamp"];
            });
        }
        
        setInterval(updateTable, 1000);
        
    </script> 
</body>
</html>
