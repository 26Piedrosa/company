<?php echo script_tag('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'); ?>
<?php echo script_tag('assets/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>
<?php echo script_tag('assets/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>
<?php echo script_tag('assets/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>