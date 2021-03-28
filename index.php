<?php
require_once "Database.php";
$database = new Database();
$db = $database->db;
$errors = '';
if (isset($_POST['submit'])){
   $text = $_POST['task'];
   if (empty($text)){
       $errors = 'You must fill in the task';
   }else{
       $query = 'INSERT INTO list_tasks (text) VALUES (?)';
       $result = $db->prepare($query);
       $result->bindValue(1,$text);
       $result->execute();
   }

}

if (isset($_GET['del_task']) && !empty($_GET['del_task'])){
    $task_id= $_GET['del_task'];
    $ans = $db->prepare('DELETE FROM list_tasks WHERE id=?');
    $ans->bindValue(1,$task_id);
    $ans->execute();
    header('location:index.php');
}
?>


<!DOCTYPE html>
<html>
<head>
    <title> برنامه لیست کارها با پی اچ پی</title>
    <style>
        .heading{
            width: 50%;
            margin: 30px auto;
            text-align: center;
            color: #535353;
            background: #ccf3ef;
            border: 2px solid #7acdaf;
            border-radius: 20px;
        }
        form {
            width: 50%;
            margin: 30px auto;
            border-radius: 5px;
            padding: 10px;
            background: #ccf3ef;
            border: 1px solid #7acdaf;
        }
        form p {
            color: red;
            margin: 0px;
        }
        .task_input {
            width: 75%;
            height: 15px;
            padding: 10px;
            border: 1px solid #bcbcbc;
        }
        .add_btn {
            height: 39px;
            background: #7ee3c4;
            color: #000000;
            border: 2px solid #bcbcbc;
            border-radius: 5px;
            padding: 5px 20px;
        }

        table {
            width: 50%;
            margin: 30px auto;
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px solid #cbcbcb;
            text-align: left;
        }

        th {
            font-size: 19px;
            color: #696969;
        }

        th, td{
            border: none;
            height: 30px;
            padding: 2px;
        }

        tr:hover {
            background: #E9E9E9;
        }

        .task {
            text-align: left;
        }

        .delete{
            text-align: center;
        }
        .delete a{
            color: white;
            background: #a52a2a;
            padding: 1px 6px;
            border-radius: 3px;
            text-decoration: none;
        }
        .footer{
            text-align: center;
            font-size: 1em !important;
            color: gray;
        }
    </style>
</head>
<body>
<div class="heading">
    <h2 style="font-style: 'Hervetica';">ToDoList with PHP - mySql</h2>
</div>
<table>
    <thead>
    <tr>
        <th>N</th>
        <th>Tasks</th>
        <th style="width: 60px;">Action</th>
    </tr>
    </thead>

    <tbody>
    <?php
        $tasks = $db->prepare('SELECT * FROM list_tasks');
        $tasks->execute();
        $res = $tasks->fetchAll();
        foreach ($res as $item){
    ?>
        <tr>
            <td> <?php echo $item['id'] ?> </td>
            <td class="task"> <?php echo $item['text'] ?> </td>
            <td class="delete">
                <a href="index.php?del_task=<?php echo $item['id'] ?>">x</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<form method="post" action="index.php" class="input_form">
    <?php if (isset($errors)) { ?>
        <p><?php echo $errors; ?></p>
    <?php } ?>
    <input type="text" name="task" class="task_input">
    <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
</form>

<h2 class="footer">Programmer : <a href="http://mrkomeil.ir/" target="_blank" style="color: darkslategray">Komeil Yeganeh</a></h2>
</body>
</html>












