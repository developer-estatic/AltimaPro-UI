/**
 * Global DataTables Initialization
 * Automatically initializes DataTables on any table with class 'auto-datatable'
 * or any table with class 'table' that doesn't already have DataTables
 */




jQuery(document).ready(function($) {
    // alert("vdagh");
    // Create loader element
    const loaderHtml = `
        <div id="page-loader">
            <div class="loader-overlay">
                <div class="spinner"></div>
            </div>
        </div>
    `;
    $('body').append(loaderHtml);

    // Add loader styles
    const loaderStyles = `
        <style id="loader-style">
            .loader-overlay {
                position: fixed;
                inset: 0;
                background: rgba(255, 255, 255, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                transition: opacity 0.5s ease;
            }
            .spinner {
                width: 50px;
                height: 50px;
                border: 5px solid #ddd;
                border-top: 5px solid #007bff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            #page-loader.hidden {
                opacity: 0;
                pointer-events: none;
            }
        </style>
    `;
    $('head').append(loaderStyles);

    // Hide loader after 3 seconds
    setTimeout(function() {
        $('#page-loader').addClass('hidden');
        setTimeout(function() {
            $('#page-loader').remove();
        }, 1000);
    }, 3000);
});




document.addEventListener('DOMContentLoaded', function() {
    // Default DataTable configuration - Anonymous/global for all tables
    var defaultConfig = {
        pageLength: 20,
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, 'All']],
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        scrollY: '560px',
        scrollX: true,
        scrollCollapse: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        language: {
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            paginate: {
                first: '«',
                last: '»',
                next: '›',
                previous: '‹'
            },
            search: '',
            searchPlaceholder: 'Search'
        },
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: 'no-sort' },
            { orderable: false, targets: -1 }
        ],
        pagingType: 'full_numbers',
        retrieve: true
    };

    function buildColumnDefsForTable($table) {
        return [];
    }

    function enforceOrderingOnExisting($table) {
        if (!$table || !$table.length) return;
        if (!$.fn.DataTable.isDataTable($table)) return;
        var api = $table.DataTable();
        var total = api.columns().count();
        for (var i = 0; i < total; i++) {
            api.column(i).orderable(true);
        }
        api.columns.adjust();
    }

    var __dt_last_init_at = 0;
    var __dt_is_running = false;

    function initDataTables() {
        if (__dt_is_running) return;
        var now = Date.now();
        if (now - __dt_last_init_at < 500) return;
        __dt_is_running = true;
        __dt_last_init_at = now;
        
        $('table:not(.no-datatable)').each(function() {
            if ($(this).closest('.dataTables_scrollHead, .dt-scroll-head').length) return;

            var tableId = $(this).attr('id') || 'table-' + Math.random().toString(36).substr(2, 9);

            if ($.fn.DataTable.isDataTable(this)) return;
            if ($(this).attr('data-dt-init') === '1') return;

            try {
                $(this).attr('data-dt-init', '1');
                var perTableConfig = $.extend(true, {}, defaultConfig);
                perTableConfig.initComplete = function() {
                    var api = this.api();
                    api.columns.adjust();
                };
                perTableConfig.columnDefs = buildColumnDefsForTable($(this));

                var $tbl = $(this);
                var dt = $tbl.DataTable(perTableConfig);

                // Immediately adjust and enforce column ordering
                dt.columns.adjust();
                enforceOrderingOnExisting($tbl);

                // Attach simple header click sorting
                try {
                    var $wrapper = $tbl.closest('.dataTables_wrapper');
                    var $heads = $wrapper.find('.dataTables_scrollHead thead');
                    if (!$heads.length) $heads = $tbl.closest('.dataTables_wrapper').find('thead');

                    $heads.off('click.dtGlobalSort', 'th');
                    $heads.on('click.dtGlobalSort', 'th', function(e) {
                        var colIndex = $(this).index();
                        if (colIndex < 0) return;
                        if ($(this).hasClass('no-sort')) return;
                        var current = dt.order();
                        var dir = 'asc';
                        if (current && current.length && current[0][0] === colIndex) {
                            dir = current[0][1] === 'asc' ? 'desc' : 'asc';
                        }
                        dt.order([colIndex, dir]).draw();
                    });
                } catch (err) {
                    console.warn('Header sort binding failed', err);
                }
            } catch (e) {
                $(this).removeAttr('data-dt-init');
            }
        });

        __dt_is_running = false;
    }

    // Initial initialization
    initDataTables();

    // Reinitialize on Livewire updates
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('message.processed', (message, component) => {
            initDataTables();
        });
    }

    // Observe DOM for newly added tables
    var observer = new MutationObserver(function(mutations) {
        var shouldInit = false;
        var shouldWireTooltips = false;
        mutations.forEach(function(m) {
            if (m.addedNodes && m.addedNodes.length) {
                $(m.addedNodes).each(function() {
                    if ($(this).is && $(this).is('table')) {
                        if (!$(this).hasClass('no-datatable') && !$(this).closest('.dataTables_scrollHead, .dt-scroll-head').length) {
                            if (!$.fn.DataTable.isDataTable(this) && $(this).getAttribute('data-dt-init') !== '1') {
                                shouldInit = true;
                            }
                        }
                    } else if ($(this).find) {
                        var $tables = $(this).find('table:not(.no-datatable)')
                            .filter(function() {
                                return !$(this).closest('.dataTables_scrollHead, .dt-scroll-head').length &&
                                       !$.fn.DataTable.isDataTable(this) &&
                                       $(this).attr('data-dt-init') !== '1';
                            });
                        if ($tables.length) shouldInit = true;
                    }
                    // Any tooltip structures added?
                    if ($(this).find && $(this).find('ui-tooltip,[data-flux-tooltip]').length) {
                        shouldWireTooltips = true;
                    }
                });
            }
        });
        if (shouldInit) initDataTables();
        if (shouldWireTooltips) wireTooltips();
    });
    observer.observe(document.body, { childList: true, subtree: true });

    // Re-adjust columns on window resize
    var resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            $('table.dataTable').each(function() {
                var $t = $(this);
                var api = $t.DataTable();
                if (api) { api.columns.adjust(); enforceOrderingOnExisting($t); }
            });
        }, 1000);
    });

    // -------- Global tooltip wiring (convert ui-tooltip → Bootstrap tooltip) --------
    function wireTooltips() {
        try {
            $('[data-toggle="tooltip"]').tooltip('destroy');
        } catch(e) { /* ignore */ }

        $('ui-tooltip[data-flux-tooltip], [data-flux-tooltip]').each(function() {
            var $wrap = $(this);
            var $btn = $wrap.find('[data-flux-button], button, a').first();
            if (!$btn.length) return;
            var $content = $wrap.find('[data-flux-tooltip-content]').first();
            var text = ($content.text() || $btn.attr('aria-label') || '').trim();
            if (!text) return;
            $btn.attr('data-toggle', 'tooltip')
                .attr('data-placement', 'top')
                .attr('title', text);
        });

        // Init Bootstrap tooltip for all prepared elements
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body',
            html: false,
            trigger: 'hover focus',
            placement: function(){ return 'top'; }
        });
    }

    // Initial tooltip wiring
    wireTooltips();

    // Keep DataTables layout stable when modals open/close
    $(document).on('shown.bs.modal hidden.bs.modal', function() {
        try {
            $('[data-toggle="tooltip"]').tooltip('hide');
        } catch(e) {}
        $('table.dataTable').each(function() {
            var api = $(this).DataTable();
            if (api) { api.columns.adjust(); }
        });
    });
});
