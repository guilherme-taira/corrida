<template>
    <v-container class="mt-4">
        <v-card>
            <v-card-title>Editar Evento</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="salvarEdicao" ref="form">
                    <v-text-field
                        label="Título do Evento"
                        v-model="form.name"
                        required
                    />
                    <v-text-field
                        label="Local do Evento"
                        v-model="form.local"
                    />
                    <v-text-field
                        label="Cidade do Evento"
                        v-model="form.cidade"
                    />

                    <v-switch
                        label="Exibir Tempo Líquido"
                        v-model="form.exibir_tempo_liquido"
                    />
                    <v-switch label="Exibir GAP" v-model="form.exibir_gap" />
                    <v-switch
                        label="Exibir Tempo Bruto"
                        v-model="form.exibir_tempo_bruto"
                    />

                    <!-- Mostrar imagem atual -->
                    <div v-if="form.imagemAtual" class="mt-3">
                        <strong>Imagem Atual:</strong>
                        <v-img
                            :src="`/storage/${form.imagemAtual}`"
                            max-width="200"
                            class="my-2"
                        />
                    </div>

                    <v-file-input
                        label="Nova Imagem do Evento"
                        accept="image/*"
                        v-model="form.imagem"
                        show-size
                    />

                    <!-- Mostrar banner atual -->
                    <div v-if="form.bannerAtual" class="mt-3">
                        <strong>Banner Atual:</strong>
                        <v-img
                            :src="`/storage/${form.bannerAtual}`"
                            max-width="400"
                            class="my-2"
                        />
                    </div>

                    <v-file-input
                        label="Novo Banner do Evento"
                        accept="image/*"
                        v-model="form.banner"
                        show-size
                    />

                    <v-switch label="Corrida está ao vivo?" v-model="form.isLive" />

                    <!-- Mostrar certificado atual -->
                    <div v-if="form.certificadoAtual" class="mt-3">
                        <strong>Certificado Atual:</strong>
                        <v-img
                            :src="`/storage/${form.certificadoAtual}`"
                            max-width="400"
                            class="my-2"
                        />
                    </div>

                    <v-file-input
                        label="Novo Certificado do Evento"
                        accept="image/*"
                        v-model="form.certificado"
                        show-size
                    />

                    <!-- Campo para importar Excel dos atletas -->
                    <v-file-input
                        label="Importar Atletas (Excel)"
                        accept=".xlsx, .xls"
                        v-model="form.excel"
                        show-size
                        class="mt-4"
                    />

                    <v-btn type="submit" color="primary" class="mt-4"
                        >Salvar</v-btn
                    >
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();
const id = route.params.id;

const form = ref({
    name: "",
    local: "",
    cidade: "",
    exibir_tempo_liquido: false,
    exibir_gap: false,
    exibir_tempo_bruto: false,
    imagem: null,
    banner: null,
    certificado: null,
    imagemAtual: null,
    bannerAtual: null,
    certificadoAtual: null,
    excel: null, // ✅ novo campo para o arquivo Excel
});

onMounted(() => {
    axios.get(`/resultados/${id}`).then((res) => {
        const data = res.data;
        form.value = {
            name: data.name,
            local: data.local ?? "",
            cidade: data.cidade ?? "",
            exibir_tempo_liquido: !!data.exibir_tempo_liquido,
            exibir_gap: !!data.exibir_gap,
            exibir_tempo_bruto: !!data.exibir_tempo_bruto,
            imagem: null,
            banner: null,
            certificado: null,
            imagemAtual: data.imagem,
            bannerAtual: data.banner,
            certificadoAtual: data.certificado,
            excel: null, // ✅ reset do campo
        };
    });
});

function salvarEdicao() {
    const data = new FormData();
    data.append("name", form.value.name);
    data.append(
        "exibir_tempo_liquido",
        form.value.exibir_tempo_liquido ? 1 : 0
    );
    data.append("exibir_gap", form.value.exibir_gap ? 1 : 0);
    data.append("exibir_tempo_bruto", form.value.exibir_tempo_bruto ? 1 : 0);
    data.append("local", form.value.local);
    data.append("cidade", form.value.cidade);

    if (form.value.imagem) data.append("imagem", form.value.imagem);
    if (form.value.banner) data.append("banner", form.value.banner);
    if (form.value.certificado)
        data.append("certificado", form.value.certificado);
    if (form.value.excel) data.append("arquivo_excel", form.value.excel); // ✅ anexa o Excel

    axios
        .post(`/resultados/${id}?_method=PUT`, data)
        .then(() => {
            alert("Evento atualizado com sucesso!");
            router.push("/");
        })
        .catch((error) => {
            alert("Erro ao salvar evento");
            console.error(error);
        });
}
</script>
