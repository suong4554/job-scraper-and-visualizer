<?php

$data = file_get_contents('data/company_skill_distribution.json');


if(isset($_GET['skill'])){
  $skill = $_GET['skill'];
}
else{
  $skill = "total";
}

if(isset($_GET['city'])){
  $city = $_GET['city'];
}
else{
  $city = "All Locations";
}




?>
<!DOCTYPE html>

<!-- Resources -->
<?php include 'dependencies.php';?>



<style>

#company {
  width: 50%;
  height: 1000px;
}
#chartdiv_company {
  width: 50%;
  height: 1000px;
  padding-top: 25px;
}
</style>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Job Listings</title>

  <?php include 'navbar.php';?>


</head>

<body>
  <div class"container">

    <div class="row">
      <div id="company" class="col-sm">
        <h3 id="title_listing" class="pl-3 pt-2" > </h3>
        <div class="card-deck" id="job_card_deck">
        </div>


      </div>
      <div id="chartdiv_bar" class="col-sm"></div>

      <!--<div id="chartdiv_pie" class="col-sm"></div>-->
    </div>

  </div>
</body>



<script>
var dataset = <?php echo $data; ?>;

var city = "<?php echo $city; ?>";

var skill = "<?php echo $skill; ?>";

//console.log(dataset[skill])

dataset = dataset[skill]

console.log(dataset)



var result_dataset = []
var company_count = {}
for (listing in dataset){
  listing = dataset[listing]
  if(listing.city == city || city == "All Locations"){
    if(listing.companyName){
      result_dataset.push(listing)
    }
    if (company_count.hasOwnProperty(listing.companyName)){
      company_count[listing.companyName] += 1
    }
    else{
      company_count[listing.companyName] = 1
    }
  }
}

result_dataset.sort(function( a , b ){
  var result = a.companyName.toLowerCase() == b.companyName.toLowerCase() ? 0 : b.companyName.toLowerCase() > a.companyName.toLowerCase() ? -1 : 1
  return result ;
 });

var card_deck = ""
for (listing in result_dataset){
  listing = result_dataset[listing]
  card_deck +=`
  <div class="col-sm-4 p-3">
    <div class="card h-100">
      <div class="card-body">
        <a href="${listing.url}"> <h5 class="card-title">${listing.companyName}: <br> ${listing.title}</h5> </a>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <h6 class="card-subtitle mb-2 text-muted">${listing.location}</h6>
        <p class="card-text">${listing.summary}</p>
      </div>
      <div class="card-footer">
        <small class="text-muted">${listing.date}</small>
      </div>
    </div>
  </div>`
}

if (city == "All Locations"){
  document.getElementById("title_listing").innerHTML = city + ": " + "<?php echo $skill; ?>";
}
else{
  document.getElementById("title_listing").innerHTML = listing.location + ": " + "<?php echo $skill; ?>";
}
document.getElementById("job_card_deck").innerHTML = card_deck;



//console.log(result_dataset)
var amchart_dataset_company = []
var count = 0
for (key in company_count){
  count +=1
  //console.log(genre_data[key])
  if (key != "NaN"){
    var temp = {}
    temp.name = key
    temp.value = company_count[key]
    amchart_dataset_company.push(temp)
  }
}


amchart_dataset_company.sort(function( a , b ){
  var result = a.value == b.value ? 0 : b.value < a.value ? -1 : 1
  return result ;
 });
amchart_dataset_company = amchart_dataset_company.slice(0, 20)

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv_bar", am4charts.XYChart);
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
title.text = "Listings per Company (Top 20)";
title.fontSize = 25;
title.marginBottom = 30;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series.columns.template.adapter.add("fill", function(fill, target){
  return chart.colors.getIndex(target.dataItem.index);
});

categoryAxis.sortBySeries = series;
}); // end am4core.ready()

</script>
