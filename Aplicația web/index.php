<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MonReg</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="style.css">

</head>
<body>
    <!-- <div id="blur" class="blur"></div> -->
    <nav>
          <span id="hamburger"><i class="fas fa-bars"></i></span>
      <div id="mobileMenu" class="mobile-menu">
        <ul>
            <i class="fas fa-window-close"></i>
            <li><a href="#"><i class="fas fa-home"></i> Live</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Statistici</a></li>
            <!-- <li><a href="#"><i class="fas fa-exclamation-circle"></i> Alerte</a></li> -->
          </ul>
      </div>
      <div id="sidemenu" class="sidemenu">
          <!-- <i class="fas fa-window-close"></i> --> 
          <ul>
            <!-- <p class="titlemenu">Meniu</p> -->
            <li><a href="#"><i class="fas fa-home"></i> Live</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Statistici</a></li>
            <!-- <li><a href="#"><i class="fas fa-exclamation-circle"></i> Alerte</a></li> -->
           
          </ul>
          
      </div>
    </nav>
    <header>
      <div class="title">
        <!-- <span id="hamburger"><i class="fas fa-bars"></i></span> -->
        <h2>MonReg</h2>
        <h3>Aplicație web pentru monitorizarea<br> temperaturii într-o încăpere</h3>    
      </div>
   </header>
   <main class="live">
    <h2 class="titlulive">Grafic în timp real</h2>
      <div id="container"></div>
      <div class="temp">
        <p><i id="i" class="fas fa-thermometer-empty"></i> Temperatura: <span id='tempStored' class="reading">...</span>&deg;C</p>
        <p><i id="i" class="fas fa-tint"></i> Umiditatea: <span id='humiStored' class="reading">...</span>%</p>
      </div>
      
    </main>
    <section class="statistici">
      <h2 class="titlustatistici">Statistici</h2>
      <div id="stats1"></div>
      <div id="stats2"></div>
      <form id="form" action="" method="get">
        Interval: <input id="begin_date" type="date" name="begin_date"/>-<input id="end_date" type="date" name="end_date"/>
        <input type="submit"/>
      </form>
    </section>
    
    <!-- <section class="alerte">
        <h2 class="titlualerte">Alerte</h2>
        <div class="wrapper">
            <div class="aForm">
                <form id="alerts" action="" method="get">
                    <p class="selectTemp">Selectati temperatura critica: </p>
                    <input class="templimit" id="templimit" type="number" name="altemp"/>
                    <input class="submit" type="submit" value="Aplica"/>
                </form>
            </div>
            <div class="alertset">
                <p class="genalert">Alerte generate</p>
                <div id="generatedAlerts"></div>
            </div>
        </div>
    </section>
    -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    <div class="hideMe">
    <!-- PHP -->
            
    <?php 
      include 'write_data.php';
      include 'stats.php';
      include 'prepared_statements.php';
    ?>
            
    <!-- --- -->
    
    <!-- GRAPH -->
    <div id="scriptPreStats"></div>
    <script id="sps">
    
        
           $("#form").submit(function(event){
           
              var postdata = $("#form").serialize();
              $.get("prepared_statements.php", postdata, function(response){
                $("#scriptPreStats").html(response);

              })
              
              return false;
            
           })
           
           
           $("#alerts").submit(function(event){
              var data = $("#alerts").serialize();
              $.get("setAlerts.php", data, function(res){
                $("#generatedAlerts").html(res);           
              })
              
              return false;
           })
           
           //setInterval(function(){                
           //     const tempA = document.getElementById("tempA").childNodes[0].nodeValue;
           //     const temp = document.getElementById("tempStored").childNodes[0].nodeValue;
           //     const alertTemp = document.getElementById("alertTemp");
           //   
           //     if(temp < tempA){
           //       alertTemp.remove();
           //     }}, 2000)

           
           
       
          const monthNames = ["Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie",
          "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"];   
          
          const dayNames = ["Duminica", "Luni", "Marti", "Miercuri", "Joi", "Vineri", "Sambata"];
    
          var today = new Date();
          var text = "Evoluția temperaturii azi: "
          var year = String(today.getFullYear());
          var month = today.getMonth();
          var day = String(today.getDate());
          var dayCount = String(today.getDay());
          var separator = "-";
          var nameMonth = String(monthNames[month]);   
          var nameDay = String(dayNames[dayCount]);
          
          var todayTemps = text.concat(nameDay,", ",day,separator,nameMonth,separator,year);
          
   
          stats = new Highcharts.Chart({
          chart:{
            renderTo:'stats1',
            plotBorderWidth:2,
            marginRight:50,
            type:'spline',
            backgroundColor:'white',
            zoomType: 'xy',
            style: {
              fontFamily: 'Montserrat',
              fontWeight: '400'
            }
          },
          title:{
            text:[todayTemps],
            align:'center'
          },
          xAxis:{
            title:{
              text: 'Numărul de valori'
            },
            lineColor:'black',
            lineWidth:2
          },
          yAxis:{
            title:{
              text: 'Valorile temperaturii'
            },
            lineColor:'black',
            lineWidth:2,
          },
          series:[{
            name:'Temperatura (Celsius)',
            data:mar
          }]
        });
        
        
        
        stats1 = new Highcharts.Chart({
          chart:{
            renderTo:'stats2',
            plotBorderWidth:2,
            marginRight:50,
            type:'spline',
            backgroundColor:'white',
            zoomType: 'xy',
            style: {
              fontFamily: 'Montserrat',
              fontWeight: '400'
            }
          },
          title:{
            text:'Statistică personalizată',
            align:'center'
          },
          xAxis:{
            title:{
              text: 'Numărul de valori'
            },
            lineColor:'black',
            lineWidth:2
          },
          yAxis:{
            title:{
              text: 'Valorile temperaturii'
            },
            lineColor:'black',
            lineWidth:2,
          },
          series:[{
            name:'Temperatura (Celsius)',
            data:[]
          }]
        })

        
        
        //$("#form").submit(function(e){
          //e.preventDefault();
          //let form = $(this).serialize();

          
          //$.ajax({
            
            //type:'GET',
            //url:'prepared_statements.php',
            //data: form,
            //success:function(data){
 
            //}
          
          //})
          
         
        //})
        
        
        
        //function reloadScript(){
          //$(document).ready(function(){
            //$("#stats1").load("stats.php");
            //setInterval(function(){
              //$("#stats1").load("stats.php");
            //}, 1000);
          //})
        //}
          
    </script>
    <script src="scripts.js"></script>
    <!-- ----- -->
    </div>
</body>
</html>