<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Data to Table</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function addColumn() {
            const columnContainer = document.getElementById('columns');
            const columnDiv = document.createElement('div');
            columnDiv.classList.add('column-input');

            columnDiv.innerHTML = `
                <input type="text" name="column_names[]" placeholder="Column Name" required>
                <button type="button" onclick="removeColumn(this)">Remove</button>
            `;

            columnContainer.appendChild(columnDiv);
        }

        function removeColumn(button) {
            const columnDiv = button.parentElement;
            columnDiv.remove();
        }
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1,
        h3 {
            text-align: center;
        }

        input[type="text"],
        input[type="file"] {
            width: calc(70% - 20px);
            margin: 10px 0;
            padding: 10px;
        }

        button {
            display: inline-block;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .column-input {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        button[type="button"] {
            background-color: #d9534f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Upload Data to Table</h1>
        <form action="{{ route('uploadTableData') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" name="table_name" placeholder="Table Name" required>
            <div id="columns">
                <h3>Columns</h3>
                <div class="column-input">
                    <input type="text" name="column_names[]" placeholder="Column Name" required>
                    <button type="button" onclick="removeColumn(this)">Remove</button>
                </div>
            </div>
            <button type="button" onclick="addColumn()">Add Column</button>
            <input type="file" name="file" accept=".csv" required>
            <button type="submit">Upload Data</button>
        </form>
    </div>
</body>

</html>