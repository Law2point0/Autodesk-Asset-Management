<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #cacfcc;
        }

        .header {
            margin: 0; 
            font-size: 20;
            top: 0;
            left: 0;
            margin-left: 20px;
            align-items: center;
            display: flex;
            color: white
        }

        .centered-text {
            display: flex;
        }

        .dashboard-content {
            display: flex;
            flex-direction: column; 
            padding: 20px;
        }

        .top-section {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .action-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 10;  
        }

        .project-list-container {
            flex: 1;
            border-left: 1px solid #ffff;
            padding-left: 20px;
        }

        .project-list-container h2 {
            margin-top: 0;
        }

        .project-list {
            list-style: none;
            padding: 0;
        }

        .project-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .project-list li:last-child {
            border-bottom: none;
        }

        .bottom-section {
            display: flex;
            gap: 20px;
        }

        .left-chart, .right-chart {
            flex: 1;
            height: 300px; 
            background-color: #f9f9f9; 
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #888; 
            font-size: 20;
        }

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manager dashboard</title>
</head>
<body>
    <?php
        include("NavBar.php");
    ?>
    <main>


    <header class="header">
        <h1 class="centered-text">Manager Dashboard</h1>
    </header>

    <div class="container">

        <main class="dashboard-content">

            <section class="top-section">

                <div class="action-button view-projects">View All Projects</div>
                <div class="action-button manage-members">Manage project members</div>
                <div class="project-list-container">
                    <h2>Manager Projects</h2>
                    <ul class="project-list">
                        <li>Project 1 (mass hysteria)</li>
                        <li>Project 2 (Second impact)</li>
                        <li>Project 3 (third impact)</li>
                    </ul>
                </div>
            </section>

            <section class="bottom-section">
                <div class="left-chart">
                    <div class="chart pie-chart"></div>
                </div>
                <div class="right-chart">
                   <canvas id="barchart"></canvas>
                </div>
            </section>
        </main>
    </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const ctx = document.getElementById('barchart').getContext('2d');
      const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [{
            label: 'Data 1',
            data: [65, 59, 80, 81, 56, 55],
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          },
          {
            label: 'Data 2',
            data: [28, 48, 40, 19, 86, 27],
            backgroundColor: 'rgba(255, 99, 132, 0.8)',
            borderColor: 'rgba(255, 99, 132, 1)',
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
      });
    </script>

</body>
</html>