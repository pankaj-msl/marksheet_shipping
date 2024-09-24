<template>
    <div class="max-w-7xl mx-auto py-6">
        <div class="max-w-none mx-auto">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div
                    class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
                >
                    <div class="flex-1 flex justify-between sm:hidden" />
                    <div
                        class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                    >
                        <div>
                            <slot name="showingResults"></slot>
                        </div>
                        <div>
                            <slot name="pageNumber"></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
