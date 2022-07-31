   <!-- Vendor js -->
   <script src="{{url('assets/js/vendor.min.js')}}"></script>
   <script src="{{url('assets/libs/select2/js/select2.min.js')}}"></script>
   <!-- Plugins js-->
   <script src="{{url('assets/libs/flatpickr/flatpickr.min.js')}}"></script>

   <!-- Plugins js-->
   <script src="{{url('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
   <script src="{{url('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js')}}"></script>
   <script src="{{url('assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>

   <!-- App js-->
   <script src="{{url('assets/libs/tippy.js/tippy.all.min.js')}}"></script>
   <script src="{{url('assets/js/app.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
   <script src="{{url('assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
   <script src="{{url('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
   <script src="{{url('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
   <!-- Datatables init -->
   <script src="{{url('assets/js/pages/datatables.init.js')}}"></script>
  
   <script src="{{url('assets/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
   <script>
      $('.numeric_form').on('input', function (event) { 
    this.value = this.value.replace(/[^0-9]/g, '');
});

$('.disc_form').on('input', function (event) { 
  if(!onlyNumbers(this.value)){
    this.value = this.value.replace(/[^0-9]/g, '');
  }
});

function onlyNumbers(str) {
  return /^[0-9.,]+$/.test(str);
}

const numInputs = document.querySelectorAll('input[type=number]')

numInputs.forEach(function(input) {
  input.addEventListener('change', function(e) {
    if (e.target.value == '') {
      e.target.value = 0
    }
  })
});
var timer;
//..
var startTimer = function() {
  clearTimeout(timer);
  timer = setTimeout(window.location.href = "{{ route('logout')}}", 6000);
}

$.ajax({
    type: "GET",
    url: '/notification-list',
    data: {
        _token: "{{ csrf_token() }}",
    },
    dataType: 'json',

}).done(function (msg) {
  var list=$('#list-notif');
  var count=$('#count_notif');
var element =``;
for(let i=0;i<msg.length;i++){
element+=`<a title="${msg[i].perihal}" href="/pembelian" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">${msg[i].perihal}
                                <small class="text-muted">${msg[i].tgl_notif}</small>
                            </p>
                        </a>`;
}
    //count.html(msg.length);
    list.html(element);
})


   </script>
   @yield('script');
