import { Component, AfterViewInit, AfterViewChecked } from '@angular/core';
import Chart from 'chart.js/auto';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css'],
  imports: [
    MatListModule,
    MatIconModule,
    MatButtonModule
  ]
})
export class DashboardComponent implements AfterViewChecked {

  lineChartInstance: Chart | undefined;
  earningsChartInstance: Chart | undefined;

  ngAfterViewChecked() {
    this.createLineChart();
    this.createEarningsChart();
    this.createClientsChart();
    this.createProjectsChart();
    this.createEmployeesChart();
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

  // 📌 Mini Projects Chart inside the card
  createProjectsChart() {
    const canvas = document.getElementById("projectsChart") as HTMLCanvasElement;
    if (!canvas) {
      console.error("Projects Chart canvas not found!");
      return;
    }

    this.earningsChartInstance = new Chart(canvas, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June'],
        datasets: [
          {
            label: 'Projects',
            data: [130, 150, 130, 125, 120, 129],
            borderColor: 'rgba(7, 131, 28, 0.9)',
            backgroundColor: 'rgba(7, 131, 28, 0.3)',
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
  createEmployeesChart() {
    const canvas = document.getElementById("employeesChart") as HTMLCanvasElement;
    if (!canvas) {
      console.error("Employees Chart canvas not found!");
      return;
    }

    this.earningsChartInstance = new Chart(canvas, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June'],
        datasets: [
          {
            label: 'Employees',
            data: [130, 150, 130, 125, 120, 129],
            borderColor: 'rgba(20, 178, 218, 0.9)',
            backgroundColor: 'rgba(20, 178, 218, 0.3)',
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
