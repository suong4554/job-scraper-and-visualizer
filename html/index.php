
<?php

$data = file_get_contents('data/job_skill_distribution.json');

$job_totals = file_get_contents('data/city_job_distribution.json');
$company = file_get_contents('data/company_breakdown.json');

?>
<!DOCTYPE html>





<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Home Page</title>
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
<?php include 'dependencies.php';?>



<body>


<?php include 'navbar.php';?>

<!-- HTML -->
<div class"container">

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


pieSeries.slices.template.events.on("hit", function(ev){
  skill = ev.target.dataItem.category
  console.log(skill)
  window.open("skill_company.php?skill=" + skill,"_self")
});


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
    temp.raw = key
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


function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}


level1ColumnTemplate.events.on("hit", function(ev){
  skill = ev.target.dataItem.dataContext.name
  city = htmlEntities(ev.target.dataItem.dataContext.parent.dataContext.raw)
  window.open("skill_company.php?skill=" + skill + "&city=" + city,"_self")
});




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
