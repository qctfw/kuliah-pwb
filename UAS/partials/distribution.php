<?php
if (isset($_GET['edit'])) {
    $edit_dis_query = mysqli_query($connection, 'SELECT * FROM distributions WHERE id = ' . mysqli_real_escape_string($connection, $_GET['edit']));
    $edit_dis = mysqli_fetch_assoc($edit_dis_query);
}

if (isset($_POST['create'])) {
    $school = mysqli_real_escape_string($connection, $_POST['school']);
    $class = intval($_POST['class']);
    $jumlah = intval($_POST['jumlah']);

    $query = mysqli_query($connection, "INSERT INTO distributions (school, class, jumlah) VALUES ('$school', $class, $jumlah)");
    if (mysqli_affected_rows($connection) > 0) {
        echo <<<JS
        <script>
            alert('Berhasil disimpan!');
        </script>
        JS;
    }
}
elseif (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $school = mysqli_real_escape_string($connection, $_POST['school']);
    $class = intval($_POST['class']);
    $jumlah = intval($_POST['jumlah']); 

    $query = mysqli_query($connection, "UPDATE distributions SET school = '$school', class = $class, jumlah = $jumlah WHERE id = $id");
    if (mysqli_affected_rows($connection) > 0) {
        echo <<<JS
        <script>
            alert('Berhasil diubah!');
            window.location.href = '?menu=distribution';
        </script>
        JS;
        exit();
    } else {
        echo <<<JS
        <script>
            alert('Gagal diubah!');
        </script>
        JS;
        echo mysqli_error($connection);
        exit();
    }
}
elseif (isset($_POST['delete'])) {
    $id = intval($_POST['delete']);

    $query = mysqli_query($connection, "DELETE FROM distributions WHERE id = $id");
    if (mysqli_affected_rows($connection) > 0) {
        echo <<<JS
        <script>
            alert('Berhasil dihapus!');
            window.location.href = '?menu=distribution';
        </script>
        JS;
        exit();
    } else {
        echo <<<JS
        <script>
            alert('Gagal dihapus!');
        </script>
        JS;
        echo mysqli_error($connection);
        exit();
    }
}

$distributions_query = mysqli_query($connection, 'SELECT * FROM distributions');
?>
<h2>Distribusi LKS</h2>
<form method="post" id="form-input">
    <?php
    if (!empty($edit_dis)):
    ?>
    <p>ID: <?= $edit_dis['id'] ?></p>
    <input type="hidden" value="<?= $edit_dis['id'] ?>" name="id" />
    <?php
    endif;
    ?>
    <table>
        <tr>
            <td>Nama Sekolah</td>
            <td>:</td>
            <td><input type="text" name="school" /></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>
                <input type="radio" name="class" value="1" id="class-radio-1" /><label for="class-radio-1"> 1 </label>
                <input type="radio" name="class" value="2" id="class-radio-2" /><label for="class-radio-2"> 2 </label>
                <input type="radio" name="class" value="3" id="class-radio-3" /><label for="class-radio-3"> 3 </label>
                <input type="radio" name="class" value="4" id="class-radio-4" /><label for="class-radio-4"> 4 </label>
                <input type="radio" name="class" value="5" id="class-radio-5" /><label for="class-radio-5"> 5 </label>
                <input type="radio" name="class" value="6" id="class-radio-6" /><label for="class-radio-6"> 6 </label>
            </td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td>:</td>
            <td><input type="number" name="jumlah" /></td>
        </tr>
        <tr>
            <td colspan="3">
                <?php if (empty($edit_dis)): ?>
                <button type="submit" name="create">Submit</button>
                <?php else: ?>
                <button type="submit" name="edit">Update</button>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</form>

<h2>Data Distribusi</h2>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Sekolah</th>
            <th>Kelas</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($distributor = mysqli_fetch_assoc($distributions_query)):
        ?>
        <tr>
            <td><?= $distributor['id'] ?></td>
            <td><?= $distributor['school'] ?></td>
            <td><?= $distributor['class'] ?></td>
            <td><?= $number_formatter->format($distributor['jumlah']) ?></td>
            <td>
                <a href="?menu=distribution&edit=<?= $distributor['id'] ?>"><button>Edit</button></a>
                <form method="post">
                    <button type="submit" name="delete" value="<?= $distributor['id'] ?>">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
if (!empty($edit_dis)):
?>
<script type="text/javascript">
    let form = document.getElementById('form-input');
    form.querySelector('input[name="school"]').value = "<?= $edit_dis['school'] ?>";
    form.querySelector('input#class-radio-<?= $edit_dis['class'] ?>').checked = true;
    form.querySelector('input[name="jumlah"]').value = <?= $edit_dis['jumlah'] ?>;
</script>
<?php
endif;
?>