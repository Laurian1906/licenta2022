       function openSideMenu(){
          mobileMenu = document.getElementById('mobileMenu');
          hamburger = document.getElementById('hamburger');
          close = document.getElementsByClassName('fa-window-close')[0];

          hamburger.onclick = function(){
            mobileMenu.style = "display: flex;transition: 0.3s all ease;";
            blur.style = "display: block; transition: 0.3s all ease;";
          }

          close.onclick = function(){
            mobileMenu.style = "display: none; transition: 0.3s all ease;";
            blur.style = "display: none; transition: 0.3s all ease;";

          }

        }
        openSideMenu()

        function GetReadings() {
          //var temperature = tempValue; 
          
          $.get("write_data.php", function(data){
              var temperature = JSON.parse(data.temp);
              var umiditate = JSON.parse(data.humi);
              document.getElementById("tempStored").innerHTML = temperature;
              document.getElementById("humiStored").innerHTML = umiditate;
          }, "json");
         
          
          var temp = document.getElementsByClassName("reading")[0];
          var i = document.getElementById("i");
          if(temp.childNodes[0].nodeValue >= 22.00 ){
            i.className = "fas fa-thermometer-half";   
            i.style = "color: #0af556;";  
            temp.style = "color: #0af556;";
          }             
          if(temp.childNodes[0].nodeValue < 22.00){
            i.className = "fas fa-thermometer-quarter";
            i.style = "color: #0af5ee;" 
            temp.style = "color: #0af5ee;";
          }
          if(temp.childNodes[0].nodeValue >= 25.00){
            i.className = "fas fa-thermometer-three-quarters";
            i.style = "color: #f5d30a;"
            temp.style = "color: #f5d30a;";
          }
          if(temp.childNodes[0].nodeValue >= 32.00){
            i.className = "fas fa-thermometer-full";
            i.style = "color: #f50a0a;"
            temp.style = "color: #f50a0a;";
          }         
         setTimeout('GetReadings()', 10000);
        
        }


        
        //CHART

        chart = new Highcharts.Chart({
          chart:{
            renderTo:'container',
            plotBorderWidth:2,
            marginRight:50,
            type:'spline',
            backgroundColor:'white',
            style: {
              fontFamily: 'Montserrat',
              fontWeight: '400'
            }
          },
          title:{
            text:'',
            align:'center'
          },
          xAxis:{
            title:{
              text: "Numărul de valori",
            },
            lineColor:'black',
            lineWidth:2
          },
          yAxis:{
            title:{
              text:"Valori"
            },
            lineColor:'black',
            lineWidth:2,
          },
          series:[{
            name:'Temperatura (Celsius)',
            data:[]
          },{
            name:'Umiditatea (Procente)',
            data:[]
          }]
        })

        // === 

        

        setInterval(function(){
          var x = document.getElementById('tempStored').childNodes[0].nodeValue;
          var t = parseFloat(x);
          var y = document.getElementById('humiStored').childNodes[0].nodeValue;
          var z = parseFloat(y);
          
          shift = chart.series[0].data.length > 150;
          chart.series[0].addPoint(t, true, shift);
          
          shift2 = chart.series[1].data.length > 150;
          chart.series[1].addPoint(z, true, shift2);
          
        }, 2000)

        document.addEventListener('DOMContentLoaded', function() {
          GetReadings(); 
        }, false);

        

