<?php
function getData(string $table)
{
    global $connection;
    $query = mysqli_query($connection, 'SELECT * FROM ' . $table . ' ORDER BY class ASC');
    $result = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $result[] = $data;
    }

    return $result;
}

$stocks = getData('stocks');
$distributions = getData('distributions');

foreach ($distributions as $distributor) {
    $stock_index = array_search($distributor['class'], array_column($stocks, 'class'));
    if ($stock_index !== false) {
        $stocks[$stock_index]['jumlah'] -= $distributor['jumlah']; 
    }
}
?>
<h2>Cek Stock</h2>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Nilai Persediaan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stocks as $stock): ?>
        <tr>
            <td><?= $stock['id'] ?></td>
            <td><?= $stock['class'] ?></td>
            <td><?= $number_formatter->format($stock['jumlah']) ?></td>
            <td><?= $currency_formatter->format($stock['harga']) ?></td>
            <td><?= $currency_formatter->format($stock['jumlah'] * $stock['harga']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>