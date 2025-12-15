</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; SolutionsForYou {{ date('Y') }} - Admin Panel</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('admin.logout') }}">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('admin/admin-assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/admin-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('admin/admin-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('admin/admin-assets/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('admin/admin-assets/vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('admin/admin-assets/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('admin/admin-assets/js/demo/chart-pie-demo.js') }}"></script>
<!-- CKEditor 5 Classic build CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
!-- First load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    (async function() {
        // 1) path to your site CSS that you want in editor
        const cssUrl = '/css/app.css'; // change to your real CSS path

        // 2) fetch CSS text (optional: you can inline only the parts you need)
        let cssText = '';
        try {
            const resp = await fetch(cssUrl);
            if (resp.ok) cssText = await resp.text();
        } catch (e) {
            console.warn('Could not load site CSS for editor:', e);
        }

        // 3) create editor with contentStyle using fetched css
        ClassicEditor.create(document.querySelector('#editor'), {
                toolbar: ['heading', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
                    'insertTable', 'undo', 'redo', 'imageUpload'
                ],
                // Inject the site's CSS into the editor editable area so styles remain same
                contentStyle: cssText + `
      /* Optional: ensure images don't overflow */
      img { max-width:100%; height:auto; }
      /* Ensure editor content background is transparent to inherit page bg */
      :root { background: transparent; }
    `
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    })();
</script>
<x-toast />

</body>

</html>
