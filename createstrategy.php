
<form class = "form-custom" action="index.php?page=creatingstrategy" method="POST">
    <h1>Create Strategy</h1>
    <input type="text" class="form-control" name="name" placeholder="Strategy Name" required>
    <input class="form-control" list="typelist" name="typelist" required placeholder="Strategy is for...">
    <datalist id="typelist">
        <option value="Attacking">
        <option value="Defending">
        <option value="Both">
    </datalist>
    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form>
