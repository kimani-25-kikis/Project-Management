import { Component, AfterViewInit, AfterViewChecked } from '@angular/core';
import Chart from 'chart.js/auto';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app2-dashboard',
  templateUrl: './dashboard2.component.html',
  styleUrls: ['./dashboard2.component.css'],
  imports: [
    MatListModule,
    MatIconModule,
    MatButtonModule
  ]
})
export class Dashboard2Component implements AfterViewChecked {

  lineChartInstance: Chart | undefined;
  earningsChartInstance: Chart | undefined;

  ngAfterViewChecked() {
    this.createLineChart();
    this.createEarningsChart();
    this.createClientsChart();
    this.createDoughnutChart();
    this.createDolarLineChart();

  }

  // 📌 Main Line Chart (Revenue & Projects)
  createLineChart() {
    const canvas = document.getElementById("chartCanvas") as HTMLCanvasElement;
    if (!canvas) {
      console.error("Line Chart canvas not found!");
      return;
    }

    this.lineChartInstance = new Chart(canvas, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
          
          {
            type: 'bar', // Bar chart for Projects
            label: 'Project A',
            data: [5, 15, 30, 20, 10, 45, 90, 50, 70, 40, 60, 100],
            backgroundColor: 'rgba(0, 0, 0, 0.6)',
            borderColor: 'rgba(0, 0, 0, 0.4)',
            borderWidth: 1
          },
          {
            label: 'Project C',
            data: [10, 20, 40, 15, 50, 70, 20, 30, 45, 60, 80, 90],
            borderColor: 'orange',
      
            tension: 0.4,
            pointRadius: 0, 
            pointHoverRadius: 0
          },
          {
            label: 'Project B',
            data: [5, 15, 30, 20, 10, 45, 90, 50, 70, 40, 60, 100],
            borderColor: 'rgba(128, 0, 128, 0.9)',
            backgroundColor: 'rgba(128, 0, 128, 0.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 0, 
            pointHoverRadius: 0
          },
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        },
        scales: {
          x: { 
            display: true, // ✅ Show x-axis and labels
            title: { 
              display: true,
              text: 'Year 2025', // ✅ Optional: Label for x-axis
              color: 'black',
              font: { size: 14 }
            }
          }, 
          y: { 
            display: true,
            title: { 
              display: true,
              text: 'Revenue', // ✅ Optional: Label for y-axis
              color: 'black',
              font: { size: 14 }
            }
          }
        }
      }
    });
  }

   // 📌 Main Line Chart (Revenue & Projects)
   createDolarLineChart() {
    const canvas = document.getElementById("dolarCanvas") as HTMLCanvasElement;
    if (!canvas) {
      console.error("Line Chart canvas not found!");
      return;
    }

    this.lineChartInstance = new Chart(canvas, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
        datasets: [
          
          {
            type: 'line',
            label: 'Daily Bill($)',
            data: [5, 15, 30, 20, 10, 45, 90],
            backgroundColor: 'rgba(0, 0, 0, 0.6)',
            borderColor: 'rgb(48, 15, 194)',
            borderWidth: 1,
            tension: 0.4,
            pointRadius: 0, 
            pointHoverRadius: 0
          },
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          }
        },
        scales: {
          x: { 
            display: true, // ✅ Show x-axis and labels
            title: { 
              display: true,
              text: 'Year 2025', // ✅ Optional: Label for x-axis
              color: 'black',
              font: { size: 14 }
            }
          }, 
          y: { 
            display: true,
            title: { 
              display: true,
              text: 'Amount', // ✅ Optional: Label for y-axis
              color: 'black',
              font: { size: 14 }
            }
          }
        }
      }
    });
  }

  createDoughnutChart() {
    const data = {
      labels: ['Italy', 'USA', 'India', 'Australia', 'Japan', 'Shrilanka'],
      datasets: [{
        data: [300, 50, 100,70, 110, 60],
        backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(66, 187, 42)', 'rgb(127, 20, 141)', 'rgb(214, 26, 98)'],
        hoverOffset: 4
      }]
    };

    const ctx = document.getElementById('doughnutChart') as HTMLCanvasElement;
    const myChart = new Chart(ctx, {
      type: 'doughnut',
      data: data,
      options: {
        plugins: {
          legend: {
            display: false // Hide default legend
          }
        }
      }
    });

    // Generate custom legend
    this.generateLegend(data);
  }

  generateLegend(data: any) {
    const legendContainer = document.getElementById('chartLegend');

    if (legendContainer) {
        legendContainer.innerHTML = ''; // Clear previous content

        data.labels.forEach((label: string, index: number) => {
            const color = data.datasets[0].backgroundColor[index];
            const value = data.datasets[0].data[index];

            console.log(`Color: ${color}, Label: ${label}, Value: ${value}`); // Debugging

            const row = document.createElement('tr');

            row.innerHTML = `
                <td><span class="legend-color" style="background-color: ${color}; width: 15px; height: 15px; display: inline-block;border-radius:50%;"></span></td>
                <td style="font-size: 12px;">${label}</td>
                <td style="font-size: 14px; font-weight: bold;">$${value}</td>
            `;

            legendContainer.appendChild(row);
        });
    }
}


  // 📌 Mini Earnings Chart inside the card
  createEarningsChart() {
    const canvas = document.getElementById("earningsChart") as HTMLCanvasElement;
    if (!canvas) {
      console.error("Earnings Chart canvas not found!");
      return;
    }

    this.earningsChartInstance = new Chart(canvas, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June'],
        datasets: [
          {
            label: 'Earnings',
            data: [5000, 7000, 8000, 12000, 15000, 20000],
            borderColor: 'rgba(148, 15, 209, 0.9)',
            backgroundColor: 'rgba(148, 15, 209, 0.2)',
            fill: true,
            tension: 0.4,
            pointRadius: 0, 
            pointHoverRadius: 0
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: { display: false }, // Hide X-axis for a cleaner look
          y: { display: false }  // Hide Y-axis for a mini chart
        }
      }
    });
  }

  // 📌 Mini Earnings Chart inside the card
  createClientsChart() {
    const canvas = document.getElementById("clientsChart") as HTMLCanvasElement;
    if (!canvas) {
      console.error("Clients Chart canvas not found!");
      return;
    }

    this.earningsChartInstance = new Chart(canvas, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June'],
        datasets: [
          {
            label: 'New Clients',
            data: [130, 90, 100, 125, 120, 129],
            borderColor: 'orange',
            backgroundColor: 'rgba(192, 21, 21, 0.2)',
            fill: true,
            tension: 0.4,
            pointRadius: 0, 
            pointHoverRadius: 0
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: { display: false }, // Hide X-axis for a cleaner look
          y: { display: false }  // Hide Y-axis for a mini chart
        }
      }
    });
  }

  

}
