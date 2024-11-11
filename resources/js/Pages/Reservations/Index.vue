<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                RESELunch
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Calendar -->
                        <FullCalendar :options="calendarOptions" class="mb-8" />

                        <!-- Reservation Form -->
                        <form @submit.prevent="submitForm" class="mb-8">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    お弁当の種類
                                </label>
                                <div class="mt-2">
                                    <div v-for="(name, value) in lunchTypes" :key="value" class="flex items-center">
                                        <input type="radio" :id="'lunch-type-' + value" :value="value"
                                            v-model="form.lunch_type" name="lunch_type" class="mr-2">
                                        <label :for="'lunch-type-' + value">{{ name }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    予約日
                                </label>
                                <input type="date" v-model="form.start_date"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                予約する
                            </button>
                        </form>

                        <!-- Reservations List -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            予約日
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            お弁当の種類
                                        </th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            操作
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="reservation in reservations" :key="reservation.id">
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            {{ formatDate(reservation.start) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            {{ lunchTypes[reservation.lunch_type] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <button @click="deleteReservation(reservation.id)"
                                                class="text-red-600 hover:text-red-900 mr-4">
                                                削除
                                            </button>
                                            <button @click="editReservation(reservation)"
                                                class="text-blue-600 hover:text-blue-900">
                                                編集
                                            </button>
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
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    reservations: Array,
    lunchTypes: Object
})

const form = ref({
    lunch_type: 1,
    start_date: '',
    end_date: ''
})

const calendarOptions = computed(() => ({
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    events: props.reservations,
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth'
    },
    locale: 'ja'
}))

const submitForm = () => {
    form.value.end_date = form.value.start_date
    router.post('/reservations', form.value)
}

const deleteReservation = (id) => {
    if (confirm('この予約を削除してもよろしいですか？')) {
        router.delete(`/reservations/${id}`)
    }
}
const selectedReservation = ref(null);

const editReservation = (reservation) => {
  const requestData = {
    lunch_type: form.value.lunch_type,
    start_date: reservation.start,
    end_date: reservation.end,
  }
  console.log(requestData);
  router.put(`/reservations/${reservation.id}`, requestData);

};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('ja-JP')
}
</script>