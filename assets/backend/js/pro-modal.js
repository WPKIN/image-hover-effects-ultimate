jQuery(document).ready(function ($) {
    // Inject Modal HTML
    var modalHTML = `
    <div class="modal fade" id="oxi-premium-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="oxi-premium-icon mb-3">
                        <i class="fas fa-gift fa-5x text-warning"></i>
                    </div>
                    <h3 class="modal-title font-weight-bold mb-2">Unlock PRO Features</h3>
                    <h2 class="text-warning font-weight-bold mb-3">UPTO 26% OFF</h2>
                    <p class="text-muted mb-4">Upgrade to the Pro version to enable Pro features.</p>
                    <a href="https://wpkindemos.com/imagehover/pricing/" target="_blank" class="btn btn-success btn-lg px-5">Upgrade Now</a>
                </div>
            </div>
        </div>
    </div>`;

    $('body').append(modalHTML);

    // Event Delegation for Premium Triggers
    $(document).on('click', '.oxi-premium-modal-trigger', function (e) {
        e.preventDefault();
        $('#oxi-premium-modal').modal('show');
    });

    // Handle existing premium links in dashboard
    $(document).on('click', 'a[sub-type="premium"]', function (e) {
        e.preventDefault();
        $('#oxi-premium-modal').modal('show');
    });
});
