<section class="section">
    <div class="section-header">
        <h1>Categories</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Categories</a></div>
            <div class="breadcrumb-item">List</div>
        </div>
    </div>

    <div class="section-body">
        <livewire:success-message />

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Categories List</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped" id="categoryTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@script
<script>
    document.addEventListener('livewire:navigated', () => {
        const table = $('#categoryTable').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.categories.data') }}", // Route for data fetching
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}"; // CSRF token for Laravel
                },
                error: function(xhr, error, thrown) {
                    console.error("Error loading data:", error); // Debugging server errors
                },
            },

            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search",
                emptyTable: "No records found", // Message when no data is available
                loadingRecords: "Loading...",
                processing: "Processing...",
                zeroRecords: "No matching records found",
            },

            drawCallback: function() {
                $('[data-toggle="popover"]').popover(); // Initialize Bootstrap popovers
                $('[data-toggle="tooltip"]').tooltip(); // Initialize Bootstrap tooltips
            },

            fixedHeader: true,
            columnDefs: [{
                targets: [4], // Make the 5th column (index 4) unsortable
                sortable: false,
            }],
            order: [
                [0, "asc"] // Default ordering by the 0th column
            ],

            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: (data) => data,
                },
                {
                    data: 'actions',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: (data) => data || '<span class="text-muted">No actions available</span>',
                },
            ]
        });
    });
</script>
@endscript
