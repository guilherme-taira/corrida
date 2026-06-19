<template>
    <v-container>

        <v-card>
            <v-card-title class="text-h5">
                Administração de Eventos
            </v-card-title>

            <v-data-table
                :headers="headers"
                :items="eventosOrdenados"
                :items-per-page="20"
            >

                <!-- Nome limitado -->
                <template #item.name="{ item }">
                    <span :title="item.name">
                        {{ limitarTexto(item.name, 50) }}
                    </span>
                </template>

                <!-- Cidade limitada -->
                <template #item.cidade="{ item }">
                    <span :title="item.cidade">
                        {{ limitarTexto(item.cidade, 25) }}
                    </span>
                </template>

                <!-- Local limitado -->
                <template #item.local="{ item }">
                    <span :title="item.local">
                        {{ limitarTexto(item.local, 30) }}
                    </span>
                </template>

                <!-- Botões -->
                <template #item.acoes="{ item }">

                    <div class="d-flex ga-2">

                        <v-btn
                            color="primary"
                            size="small"
                            @click="editar(item.id)"
                        >
                            Editar
                        </v-btn>

                        <v-btn
                            color="success"
                            size="small"
                            @click="dados(item.id)"
                        >
                            Dados
                        </v-btn>

                    </div>

                </template>

            </v-data-table>

        </v-card>

    </v-container>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const eventos = ref([])

const headers = [
    { title: 'ID', key: 'id' },
    { title: 'Evento', key: 'name' },
    { title: 'Ações', key: 'acoes', sortable: false }
]

onMounted(async () => {

    const { data } = await axios.get('/api/eventos')

    eventos.value = data

})

const eventosOrdenados = computed(() => {

    return [...eventos.value].sort((a, b) => b.id - a.id)

})

function limitarTexto(texto, limite) {

    if (!texto) return ''

    return texto.length > limite
        ? texto.substring(0, limite) + '...'
        : texto

}

function editar(id) {

    router.push(`/corridas/edit/${id}`)

}

function dados(id) {

    router.push(`/excel/${id}`)

}
</script>

<style scoped>

.v-card-title {
    font-weight: 600;
}

</style>
