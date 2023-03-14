
const startButton = document.getElementById('start-chart__button');
const chartContainer = document.getElementById('chart__container');
const chartConfig = {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      label: 'Messi\'s Goals',
      data: [],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
}

let chart;
Pusher.logToConsole = true;
let pusher;
startButton.onclick = ()=>{
  if(startButton.textContent === 'Start'){
    startButton.textContent = 'Stop';
    chartContainer.style.display = 'block';
    initRenderChart();
    return;
  }
  if(startButton.textContent === 'Restart'){
    startButton.textContent = 'Stop';
    startChart();
    return;
  }
  if(startButton.textContent === 'Stop'){
    startButton.textContent = 'Restart';
    stopChart();
    return;
  }
  
}

function initRenderChart(){
  optionsData = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({init: true}),
  }
  fetch('trigger.php', optionsData)
  initChartData();
  startChart();
}

function stopChart(){
  pusher.disconnect();
}

function startChart(){
  pusher = new Pusher("b1e46310abe9acbbad09",{ cluster: "eu", dashboardforceTLS: true,});
  const channel = pusher.subscribe("price-btcusd");    
  channel.bind("new-price", (data) => {
    console.log("a");
    addData(data.year, data.goals)
    if(data.end)
      startButton.textContent = 'Start';
  });
}

function addData(label, data) {
  chart.data.labels.push(label);
  chart.data.datasets.forEach((dataset) => {
      dataset.data.push(data);
  });
  chart.update();
}

function initChartData(){
  if(chart){
    stopChart();
    chart.clear();
    chart.destroy();
  }

  chart = new Chart(chartContainer, chartConfig);
  
}