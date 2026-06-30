<template>
    <v-container>

        <v-card>

            <v-card-title class="text-h5 d-flex justify-space-between align-center">

                Administração de Eventos

                <v-btn
                    color="warning"
                    prepend-icon="mdi-cloud-download"
                    @click="abrirImportacao"
                >
                    Importar Dados
                </v-btn>

            </v-card-title>

            <v-data-table
                :headers="headers"
                :items="eventosOrdenados"
                :items-per-page="20"
            >

                <template #item.name="{ item }">
                    <span :title="item.name">
                        {{ limitarTexto(item.name, 50) }}
                    </span>
                </template>

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

        <!-- Modal Importação -->
        <v-dialog
            v-model="dialogImportar"
            max-width="1000"
        >
            <v-card>

                <v-card-title>
                    Eventos do Banco Online
                </v-card-title>

                <v-card-text>

                    <v-data-table
                        :headers="headersOnline"
                        :items="eventosOnline"
                        :loading="loadingOnline"
                        :items-per-page="10"
                    >

                        <template #item.acao="{ item }">

                            <v-btn
                                color="warning"
                                size="small"
                                @click="importarEvento(item)"
                            >
                                Importar
                            </v-btn>

                        </template>

                    </v-data-table>

                </v-card-text>

                <v-card-actions>

                    <v-spacer />

                    <v-btn
                        color="grey"
                        @click="dialogImportar = false"
                    >
                        Fechar
                    </v-btn>

                </v-card-actions>

            </v-card>
        </v-dialog>

    </v-container>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const eventos = ref([])

const dialogImportar = ref(false)
const eventosOnline = ref([])
const loadingOnline = ref(false)

const headers = [
    { title: 'ID', key: 'id' },
    { title: 'Evento', key: 'name' },
    { title: 'Ações', key: 'acoes', sortable: false }
]

const headersOnline = [
    { title: 'ID', key: 'id' },
    { title: 'Evento', key: 'name' },
    { title: 'Cidade', key: 'cidade' },
    { title: 'Local', key: 'local' },
    { title: 'Ação', key: 'acao', sortable: false }
]

onMounted(async () => {

    await carregarEventos()

})

async function carregarEventos() {

    const { data } = await axios.get('/api/eventos')

    eventos.value = data

}

async function abrirImportacao() {

    dialogImportar.value = true

    loadingOnline.value = true

    try {

        const { data } = await axios.get('/api/v1/eventos-online')

        eventosOnline.value = data

    } catch (error) {

        console.error(error)

        alert('Erro ao carregar eventos online')

    } finally {

        loadingOnline.value = false

    }

}

async function importarEvento(item) {

    if (!confirm(`Importar o evento "${item.name}"?`)) {
        return
    }

    try {

        await axios.post('/api/v1/importar-evento', {
            corrida_online_id: item.id
        })

        alert('Evento importado com sucesso!')

        dialogImportar.value = false

        await carregarEventos()

    } catch (error) {

        console.error(error)

        alert('Erro ao importar evento')

    }

}

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
