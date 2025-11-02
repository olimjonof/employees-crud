<template>
  <v-container>
    <v-toolbar flat>
      <v-toolbar-title>Employees</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        label="Search"
        variant="outlined"
        dense
        hide-details
        prepend-inner-icon="mdi-magnify"
      />
      <v-btn @click="fetchEmployees" icon="mdi-refresh" />
    </v-toolbar>

    <v-data-table
      :headers="headers"
      :items="filteredEmployees"
      :loading="loading"
      class="elevation-1"
    />

  </v-container>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import axios from '@/services/api'

const loading = ref(false)
const employees = ref<any[]>([])
const search = ref('')

const headers = [
  { title: 'ID', key: 'id' },
  { title: 'First Name', key: 'first_name' },
  { title: 'Last Name', key: 'last_name' },
  { title: 'Email', key: 'email' },
  { title: 'Phone', key: 'phone' },
  { title: 'Position', key: 'position' },
  { title: 'Salary', key: 'salary' },
  { title: 'Status', key: 'status' },
]

const filteredEmployees = computed(() =>
  employees.value.filter(e =>
    Object.values(e).join(' ').toLowerCase().includes(search.value.toLowerCase())
  )
)

const fetchEmployees = async () => {
  loading.value = true
  try {
    const res = await axios.get('/employees')
    employees.value = res.data.data || res.data
  } finally {
    loading.value = false
  }
}

onMounted(fetchEmployees)
</script>
