
<?php?>
<!DOCTYPE html>





<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Home Page</title>
  <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>


<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
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
<div id="chartdiv"></div>
<p>Will popuplate fields with role key words extracted with NLP and base size off of occurence, color off of industry/location</p>

</body>




<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// create chart
var chart = am4core.create("chartdiv", am4charts.TreeMap);
chart.hiddenState.properties.opacity = 0; // this makes initial fade in effect

chart.data = [{
  name: "First",
  children: [
    {
      name: "A1",
      value: 100
    },
    {
      name: "A2",
      value: 60
    },
    {
      name: "A3",
      value: 30
    }
  ]
},
{
  name: "Second",
  children: [
    {
      name: "B1",
      value: 135
    },
    {
      name: "B2",
      value: 98
    },
    {
      name: "B3",
      value: 56
    }
  ]
},
{
  name: "Third",
  children: [
    {
      name: "C1",
      value: 335
    },
    {
      name: "C2",
      value: 148
    },
    {
      name: "C3",
      value: 126
    },
    {
      name: "C4",
      value: 26
    }
  ]
},
{
  name: "Fourth",
  children: [
    {
      name: "D1",
      value: 415
    },
    {
      name: "D2",
      value: 148
    },
    {
      name: "D3",
      value: 89
    },
    {
      name: "D4",
      value: 64
    },
    {
      name: "D5",
      value: 16
    }
  ]
},
{
  name: "Fifth",
  children: [
    {
      name: "E1",
      value: 687
    },
    {
      name: "E2",
      value: 148
    }
  ]
}];

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

var bullet1 = level1SeriesTemplate.bullets.push(new am4charts.LabelBullet());
bullet1.locationY = 0.5;
bullet1.locationX = 0.5;
bullet1.label.text = "{name}";
bullet1.label.fill = am4core.color("#ffffff");

chart.maxLevels = 2;

}); // end am4core.ready()
</script>
