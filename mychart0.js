/* ###########################
   Este Javascript es de diseño propio de cada canvas
   ###########################
*/
Chart.defaults.font.family = "Calibri";
Chart.defaults.color = "#ffffff";
  var ctx = document.getElementById("charto").getContext("2d");
  var ctx1 = document.getElementById("charto1").getContext("2d");
  var ctx2 = document.getElementById("charto2").getContext("2d");
  var ctx3 = document.getElementById("charto3").getContext("2d");

  
  //VISIBLES EN BOTONES.
  var mychart = new Chart(ctx,{
      type:"doughnut",
      data:{
          labels:['Quimica','Electricidad','Mecanica','Informatica','Sistemas','Industrial'],
          datasets:[{
              label:'Academics1',
              backgroundColor:["#2177a0", "#FFFFFF", "#000FFF", "#FFF000","#009565", "#c545ff"],
              data:[400,289,40,840,200, 190],
              hoverOffset: 25,
          }],
      },
  })
  var mychart = new Chart(ctx1,{
      type:"pie",
      data:{
          labels:['Quimica','Electricidad','Mecanica','Informatica','Sistemas','Industrial'],
          datasets:[{
              label:'Academics1',
              backgroundColor:["#2177a0", "#FFFFFF", "#000FFF", "#FFF000","#009565", "#c545ff"],
              data:[400,289,40,840,200, 190],
              hoverOffset: 25,
          }],
      },
  })
  var mychart = new Chart(ctx2,{
      type:"line",
      data:{
          labels:['Quimica','Electricidad','Mecanica','Informatica','Sistemas','Industrial'],
          datasets:[{
              label:'Record Ingresos por materia',
              backgroundColor:["#2177a0", "#FFFFFF", "#000FFF", "#FFF000","#009565", "#c545ff"],
              data:[400,289,490,840,290, 390],
          }],
      },
  })
  var mychart = new Chart(ctx3,{
      type:"polarArea",
      data:{
          labels:['Quimica','Electricidad','Mecanica','Informatica','Sistemas','Industrial'],
          datasets:[{
              label:'Academics1',
              backgroundColor:["#2177a0", "#FFFFFF", "#000FFF", "#FFF000","#009565", "#c545ff"],
              data:[200,9,40,240,200, 190],
          }],
      },
  })   

  //VISIBLES A PRIMERA VISTA.
  //CARGADO CON ARCHIVO CSV.
