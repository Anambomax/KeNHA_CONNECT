<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Calculator</title>
</head>
<body>
    <h2>Simple Calculator</h2>
    <form method="post">
        <input type="number" name="num1" placeholder="Enter first number" required>
        <select name="operator">
            <option value="+">+</option>
            <option value="-">−</option>
            <option value="*">×</option>
            <option value="/">÷</option>
        </select>
        <input type="number" name="num2" placeholder="Enter second number" required>
        <input type="submit" name="calculate" value="Calculate">
    </form>

    <?php
    if (isset($_POST['calculate'])) {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $operator = $_POST['operator'];

        switch ($operator) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                if ($num2 == 0) {
                    $result = "Cannot divide by zero";
                } else {
                    $result = $num1 / $num2;
                }
                break;
            default:
                $result = "Invalid operator";
                break;
        }

        echo "<h3>Result: $result</h3>";
    }
    ?>
</body>
</html>
