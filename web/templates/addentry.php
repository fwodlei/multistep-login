<?php if (empty($_SESSION['step-1']) ): ?>
<div class="step-1">
    <form action="./addentry.php" method="post">
        <input name="name" placeholder="Name" type="text">
        <input name="vorname" placeholder="Vorname" type="text">
        <input name="email" placeholder="Email" type="email">
        <input name="step-1" type="submit">
        <a href="private.php">Zurück zum privaten Bereich.</a>
    </form>
</div>
<?php endif; ?>

<?php if (empty($_SESSION['step-2']) && ! empty($_SESSION['step-1'])): ?>
<div class="step-2">
    <form action="./addentry.php" method="post">
        <select name="info">
            <option name="Party">Party</option>
            <option name="Arbeit">Arbeit</option>
            <option name="Kirche">Kirche</option>
        </select>
        <input name="step-2" type="submit">
    </form>
</div>
<?php endif; ?>