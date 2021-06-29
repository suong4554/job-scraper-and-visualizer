
<?php

$data = file_get_contents('data/job_skill_distribution.json');

$job_totals = file_get_contents('data/city_job_distribution.json');
$company = file_get_contents('data/company_breakdown.json');

?>
<!DOCTYPE html>





<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Home Page</title>
  <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>


<!-- Styles -->
<style>
#chartdiv {
  width: 70%;
  height: 900px;
}
#chartdiv_pie {
  width: 30%;
  height: 750px;
}
#chartdiv_bar {
  width: 50%;
  height: 500px;
}
#chartdiv_company {
  width: 50%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>



<body>


<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Mazu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
        <a class="nav-link d-flex" href="#" style='float: right'>About Us</a>
      </div>
    </div>
  </div>
</nav>

<!-- HTML -->
<div class"container">
  <div class="row" >

  </div>

  <div class="row">
    <div id="chartdiv" class="col-sm"></div>

    <div id="chartdiv_pie" class="col-sm"></div>
  </div>
  <div class="row">
    <div id="chartdiv_bar" class="col-sm"></div>
    <div id="chartdiv_company" class="col-sm"></div>

    <!--<div id="chartdiv_pie" class="col-sm"></div>-->
  </div>

</div>


</body>



<script>

var dataset = <?php echo $company; ?>;

var amchart_dataset_company = []
var count = 0
for (var key in dataset){
  count +=1
  //console.log(genre_data[key])
  var temp = {}
  temp.name = key
  temp.value = dataset[key]
  amchart_dataset_company.push(temp)
}


amchart_dataset_company.sort(function( a , b ){
  var result = a.value == b.value ? 0 : b.value < a.value ? -1 : 1
  return result ;
 });
amchart_dataset_company = amchart_dataset_company.slice(0, 10)

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv_company", am4charts.XYChart);
chart.padding(40, 40, 40, 40);
chart.data = amchart_dataset_company
var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.dataFields.category = "name";
categoryAxis.renderer.minGridDistance = 1;
categoryAxis.renderer.inversed = true;
categoryAxis.renderer.grid.template.disabled = true;

var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;

var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.categoryY = "name";
series.dataFields.valueX = "value";
series.tooltipText = "{valueX.value}"
series.columns.template.strokeOpacity = 0;
series.columns.template.column.cornerRadiusBottomRight = 5;
series.columns.template.column.cornerRadiusTopRight = 5;

var labelBullet = series.bullets.push(new am4charts.LabelBullet())
labelBullet.label.horizontalCenter = "left";
labelBullet.label.dx = 10;
labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}";
labelBullet.locationX = 1;

var title = chart.titles.create();
title.text = "Listings per Company (Top 10)";
title.fontSize = 25;
title.marginBottom = 30;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series.columns.template.adapter.add("fill", function(fill, target){
  return chart.colors.getIndex(target.dataItem.index);
});

categoryAxis.sortBySeries = series;
}); // end am4core.ready()
</script>

<script>

var dataset = <?php echo $job_totals; ?>;
var amchart_dataset_bar = []
for (var key in dataset){
  //console.log(genre_data[key])
  var temp = {}
  if (key == "sf"){
    temp.name = "San Francisco"
  }
  else if (key == "dc"){
    temp.name = "Washington D.C."
  }
  else if (key == "ny"){
    temp.name = "New York City"
  }
  else if (key == "boston"){
    temp.name = "Boston"
  }
  else if (key == "seattle"){
    temp.name = "Seattle"
  }
  else if (key == "chicago"){
    temp.name = "Chicago"
  }
  else{
    temp.name = key
  }
  temp.value = dataset[key]
  amchart_dataset_bar.push(temp)
}
console.log(amchart_dataset_bar)
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv_bar", am4charts.XYChart);
chart.padding(40, 40, 40, 40);
chart.data = amchart_dataset_bar
var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.dataFields.category = "name";
categoryAxis.renderer.minGridDistance = 1;
categoryAxis.renderer.inversed = true;
categoryAxis.renderer.grid.template.disabled = true;

var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;

var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.categoryY = "name";
series.dataFields.valueX = "value";
series.tooltipText = "{valueX.value}"
series.columns.template.strokeOpacity = 0;
series.columns.template.column.cornerRadiusBottomRight = 5;
series.columns.template.column.cornerRadiusTopRight = 5;

var labelBullet = series.bullets.push(new am4charts.LabelBullet())
labelBullet.label.horizontalCenter = "left";
labelBullet.label.dx = 10;
labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}";
labelBullet.locationX = 1;

var title = chart.titles.create();
title.text = "Jobs Per City";
title.fontSize = 25;
title.marginBottom = 30;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series.columns.template.adapter.add("fill", function(fill, target){
  return chart.colors.getIndex(target.dataItem.index);
});
categoryAxis.sortBySeries = series;
}); // end am4core.ready()
</script>






<!-- Chart code -->
<script>

var dataset = <?php echo $data ?>;


var amchart_dataset_pie = []
for (var key in dataset){
  //console.log(genre_data[key])
  var temp = {}
  if(key == "total"){
    var count = 0
    for (var data_key in dataset[key]){
        var temp_data = {
          "name": data_key,
          "value": (dataset[key][data_key])//.toFixed(2)
        }
        amchart_dataset_pie.push(temp_data)
        count +=1
      }
  }
}

amchart_dataset_pie.sort(function( a , b ){
  var result = a.value == b.value ? 0 : b.value < a.value ? -1 : 1
  if(result === 0)
  {
    // implement a tight break evaluation
  }
  return result ;
 });


amchart_dataset_pie = amchart_dataset_pie.slice(0, 18)
console.log(amchart_dataset_pie)

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv_pie", am4charts.PieChart);

// Add data
chart.data = amchart_dataset_pie

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "value";
pieSeries.dataFields.category = "name";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

var title = chart.titles.create();
title.text = "Top 18 Key Word Distribution (Total)";
title.fontSize = 25;
title.marginBottom = 30;
}); // end am4core.ready()
</script>



<!-- Chart code -->
<script>
var dataset = <?php echo $data ?>;
var amchart_dataset = []

for (var key in dataset){
  //console.log(genre_data[key])
  var temp = {}
  if(key != "total"){
    if (key == "sf"){
      temp.name = "San Francisco"
    }
    else if (key == "dc"){
      temp.name = "Washington D.C."
    }
    else if (key == "ny"){
      temp.name = "New York City"
    }
    else if (key == "boston"){
      temp.name = "Boston"
    }
    else if (key == "seattle"){
      temp.name = "Seattle"
    }
    else if (key == "chicago"){
      temp.name = "Chicago"
    }
    else{
      temp.name = key
    }
    var temp_arr = []
    for (var data_key in dataset[key]){
      var temp_data = {
        "name": data_key,
        "value": (dataset[key][data_key])//.toFixed(2)
      }
      temp_arr.push(temp_data)
    }




      temp_arr.sort(function( a , b ){
      var result = a.value == b.value ? 0 : b.value < a.value ? -1 : 1
      if(result === 0)
      {
        // implement a tight break evaluation
      }
      return result ;
     });

    temp_arr = temp_arr.slice(0, 18)



    temp.children = temp_arr
    amchart_dataset.push(temp)
  }

}
//console.log(amchart_dataset)

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// create chart
var chart = am4core.create("chartdiv", am4charts.TreeMap);
chart.hiddenState.properties.opacity = 0; // this makes initial fade in effect

chart.data =amchart_dataset

chart.colors.step = 2;

// define data fields
chart.dataFields.value = "value";
chart.dataFields.name = "name";
chart.dataFields.children = "children";

chart.zoomable = false;
var bgColor = new am4core.InterfaceColorSet().getFor("background");

// level 0 series template
var level0SeriesTemplate = chart.seriesTemplates.create("0");
var level0ColumnTemplate = level0SeriesTemplate.columns.template;

level0ColumnTemplate.column.cornerRadius(10, 10, 10, 10);
level0ColumnTemplate.fillOpacity = 0;
level0ColumnTemplate.strokeWidth = 4;
level0ColumnTemplate.strokeOpacity = 0;

// level 1 series template
var level1SeriesTemplate = chart.seriesTemplates.create("1");
var level1ColumnTemplate = level1SeriesTemplate.columns.template;

level1SeriesTemplate.tooltip.animationDuration = 0;
level1SeriesTemplate.strokeOpacity = 1;

level1ColumnTemplate.column.cornerRadius(10, 10, 10, 10)
level1ColumnTemplate.fillOpacity = 1;
level1ColumnTemplate.strokeWidth = 4;
level1ColumnTemplate.stroke = bgColor;
level1ColumnTemplate.tooltipText = "{name}: {value}"

var bullet1 = level1SeriesTemplate.bullets.push(new am4charts.LabelBullet());
bullet1.locationY = 0.5;
bullet1.locationX = 0.5;
bullet1.label.text = "{name}";
bullet1.label.fill = am4core.color("#ffffff");

var title = chart.titles.create();
title.text = "Top 18 Key Word Distribution (By City)";
title.fontSize = 25;
title.marginBottom = 30;


chart.maxLevels = 2;
chart.legend = new am4charts.Legend()

}); // end am4core.ready()
</script>
