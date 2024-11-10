<?php include 'components/header.php'; ?>
<?php include 'components/navbar.php'; ?>
<div class="container">
<?php
    if (isset($page)) {
        include 'pages/' . $page;  
    } else {
        echo "<p>Página no encontrada</p>";
    }
?>
</div>

<?php include 'components/footer.php'; ?>