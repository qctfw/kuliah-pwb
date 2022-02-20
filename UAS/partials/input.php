<?php
function checkExistingClass(int $class) {
    global $connection;
    $query = mysqli_query($connection, 'SELECT * FROM stocks WHERE class = ' . $class);

    return mysqli_num_rows($query) > 0;
}

if (isset($_GET['edit'])) {
    $edit_stock_query = mysqli_query($connection, 'SELECT * FROM stocks WHERE id = ' . mysqli_real_escape_string($connection, $_GET['edit']));
    $edit_stock = mysqli_fetch_assoc($edit_stock_query);
}

if (isset($_POST['create'])) {
    $class = intval($_POST['class']);
    $jumlah = intval($_POST['jumlah']);
    $harga = intval($_POST['harga']);

    if (checkExistingClass($class)) {
        echo <<<JS
        <script>
            alert('Validasi error. Kelas ini sudah diinput sebelumnya.');
        </script>
        JS;
    }
    else {    
        $query = mysqli_query($connection, "INSERT INTO stocks (class, jumlah, harga) VALUES ($class, $jumlah, $harga)");
        if (mysqli_affected_rows($connection) > 0) {
            echo <<<JS
            <script>
                alert('Berhasil disimpan!');
            </script>
            JS;
        }
    }
}
elseif (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $class = intval($_POST['class']);
    $jumlah = intval($_POST['jumlah']);
    $harga = intval($_POST['harga']);

    if (checkExistingClass($class)) {
        echo <<<JS
        <script>
            alert('Validasi error. Kelas ini sudah diinput sebelumnya.');
        </script>
        JS;
    }
    else {
        $query = mysqli_query($connection, "UPDATE stocks SET class = $class, jumlah = $jumlah, harga = $harga WHERE id = $id");
        if (mysqli_affected_rows($connection) > 0) {
            echo <<<JS
            <script>
                alert('Berhasil diubah!');
                window.location.href = '?menu=input';
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
}
elseif (isset($_POST['delete'])) {
    $id = intval($_POST['delete']);

    $query = mysqli_query($connection, "DELETE FROM stocks WHERE id = $id");
    if (mysqli_affected_rows($connection) > 0) {
        echo <<<JS
        <script>
            alert('Berhasil dihapus!');
            window.location.href = '?menu=input';
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

$stocks_query = mysqli_query($connection, 'SELECT * FROM stocks ORDER BY class ASC');
?>
<h2>Form Input Stock LKS</h2>
<form method="post" id="form-input">
    <?php
    if (!empty($edit_stock)):
    ?>
    <p>ID: <?= $edit_stock['id'] ?></p>
    <input type="hidden" value="<?= $edit_stock['id'] ?>" name="id" />
    <?php
    endif;
    ?>
    <table>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>
                <select name="class" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td>:</td>
            <td><input type="number" name="jumlah" required /></td>
        </tr>
        <tr>
            <td>Harga</td>
            <td>:</td>
            <td><input type="number" name="harga" required /></td>
        </tr>
        <tr>
            <td colspan="3">
                <?php if (empty($edit_stock)): ?>
                <button type="submit" name="create">Submit</button>
                <?php else: ?>
                <button type="submit" name="edit">Update</button>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</form>

<h2>Data Stock LKS</h2>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Nilai Persediaan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $all_lks = 0;
        $total_persediaan = 0;
        while ($stock = mysqli_fetch_assoc($stocks_query)):
        ?>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $stock['class'] ?></td>
            <td><?= $number_formatter->format($stock['jumlah']) ?></td>
            <td><?= $currency_formatter->format($stock['harga']) ?></td>
            <td><?= $currency_formatter->format($stock['jumlah'] * $stock['harga']) ?></td>
            <td>
                <a href="?menu=input&edit=<?= $stock['id'] ?>"><button>Edit</button></a>
                <form method="post">
                    <button type="submit" name="delete" value="<?= $stock['id'] ?>">Hapus</button>
                </form>
            </td>
        </tr>
        <?php
        $no++;
        $all_lks += $stock['jumlah'];
        $total_persediaan += ($stock['jumlah'] * $stock['harga']);
        endwhile;
        ?>
    </tbody>
</table>
<p>Jumlah LKS Seluruh: <input id="" type="number" value="<?= $all_lks ?>" readonly="readonly" /></p>
<p>Total Nilai Persediaan: <input id="" type="number" value="<?= $total_persediaan ?>" readonly="readonly" /></p>

<?php
if (!empty($edit_stock)):
?>
<script type="text/javascript">
    let form = document.getElementById('form-input');
    form.querySelector('select[name="class"]').value = <?= $edit_stock['class'] ?>;
    form.querySelector('input[name="jumlah"]').value = <?= $edit_stock['jumlah'] ?>;
    form.querySelector('input[name="harga"]').value = <?= $edit_stock['harga'] ?>;
</script>
<?php
endif;
?>