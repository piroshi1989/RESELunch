<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                RESELunch - 管理画面
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">予約集計</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            日付
                                        </th>
                                        <th v-for="(name, type) in lunchTypes" :key="type"
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            {{ name }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(counts, date) in summaries" :key="date">
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            {{ formatDate(date) }}
                                        </td>
                                        <td v-for="(name, type) in lunchTypes" :key="type"
                                            class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            {{ counts[type] || 0 }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white shadow mt-8">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 text-sm">
                    Created by: Fukumizu
                </p>
            </div>
        </footer>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    summaries: Object,
    lunchTypes: Object
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('ja-JP')
}
</script>