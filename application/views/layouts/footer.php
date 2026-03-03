    </div>
  </section>
</div>

<footer class="main-footer">
  <strong>SIMRS Laundry</strong> - Linen RS
</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>


<script>
  // helper: add/remove row dynamic items
  $(document).on('click','.btn-add-row', function(){
    var tpl = $('#row-template').html();
    $('#items-body').append(tpl);
  });
  $(document).on('click','.btn-remove-row', function(){
    $(this).closest('tr').remove();
  });


</script>

<script>
$(document).ready(function () {
  $('#datatable').DataTable({
    responsive: true,
    autoWidth: false,
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    language: {
      search: "Cari:",
      lengthMenu: "Tampilkan _MENU_ data",
      info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
      infoEmpty: "Tidak ada data",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Next",
        previous: "Prev"
      }
    }
  });
});
</script>

</body>
</html>
