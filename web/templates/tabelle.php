<table border="1" cellpadding="10">
  <thead>
  <tr>
    <?php foreach ($vars['columns'] as $column): ?>
      <th>
        <?= htmlspecialchars($column) ?>
      </th>
    <?php endforeach; ?>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($vars['rows'] as $row):?>
    <tr>
      <?php foreach ($row as $value): ?>
        <td>
          <?= htmlspecialchars($value) ?>
        </td>
      <?php endforeach; ?>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>