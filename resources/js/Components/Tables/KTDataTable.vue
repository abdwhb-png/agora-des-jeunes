<template>
    <div class="grid">
        <div class="card card-grid min-w-full">
            <div class="card-header py-5 flex-wrap">
                <h3 class="card-title">DataTable Example</h3>
            </div>
            <div class="card-body">
                <div
                    data-datatable="true"
                    data-datatable-page-size="5"
                    data-datatable-state-save="true"
                    id="my_datatable"
                >
                    <div class="scrollable-x-auto">
                        <table
                            class="table table-auto table-border"
                            data-datatable-table="true"
                        >
                            <thead>
                                <tr>
                                    <th class="w-14">
                                        <input
                                            class="checkbox checkbox-sm"
                                            data-datatable-check="true"
                                            type="checkbox"
                                        />
                                    </th>
                                    <th class="text-center">
                                        <span class="sort">
                                            <span class="sort-label">
                                                Column 1
                                            </span>
                                            <span class="sort-icon"> </span>
                                        </span>
                                    </th>
                                    <th class="min-w-[185px]">
                                        <span class="sort">
                                            <span class="sort-label">
                                                Column 2
                                            </span>
                                            <span class="sort-icon"> </span>
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input
                                            class="checkbox checkbox-sm"
                                            data-datatable-row-check="true"
                                            type="checkbox"
                                            value="1"
                                        />
                                    </td>
                                    <td>Column 1</td>
                                    <td>Column 2</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="card-footer justify-center md:justify-between flex-col md:flex-row gap-3 text-gray-600 text-2sm font-medium"
                    >
                        <div class="flex items-center gap-2">
                            Show
                            <select
                                class="select select-sm w-16"
                                data-datatable-size="true"
                                name="perpage"
                            ></select>
                            per page
                        </div>
                        <div class="flex items-center gap-4">
                            <span data-datatable-info="true"> </span>
                            <div
                                class="pagination"
                                data-datatable-pagination="true"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
