<template>
    <v-container class="mt-4">
        <v-card>
            <v-card-title>Cadastrar Nova Corrida</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="cadastrarCorrida" ref="form">
                    <v-text-field
                        label="Título da Corrida"
                        v-model="form.name"
                        required
                    />
                    <v-text-field
                        label="Local da Corrida"
                        v-model="form.local"
                    />
                    <v-text-field
                        label="Cidade da Corrida"
                        v-model="form.cidade"
                    />
                    <v-textarea
                        label="Dados adicionais (JSON)"
                        v-model="form.dados"
                        rows="5"
                        outlined
                        class="mt-4"
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
                    <v-switch label="Corrida está ao vivo?" v-model="form.isLive" />

                    <v-file-input
                        label="Imagem do Evento"
                        accept="image/*"
                        v-model="form.imagem"
                        show-size
                    />
                    <v-file-input
                        label="Banner do Evento"
                        accept="image/*"
                        v-model="form.banner"
                        show-size
                    />
                    <v-file-input
                        label="Imagem do Certificado"
                        accept="image/*"
                        v-model="form.certificado"
                        show-size
                    />

                    <v-file-input
                        label="Importar Atletas (Excel)"
                        accept=".xlsx, .xls"
                        v-model="form.excel"
                        show-size
                        class="mt-4"
                    />

                    <v-btn type="submit" color="primary" class="mt-4"
                        >Cadastrar</v-btn
                    >
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: "",
                local: "",
                cidade: "",
                exibir_tempo_liquido: false,
                exibir_gap: false,
                exibir_tempo_bruto: false,
                isLive: false, // <-- importante!
                imagem: null,
                banner: null,
                certificado: null,
                excel: null,
                dados: "", // novo campo
            },
        };
    },
    methods: {
        async cadastrarCorrida() {
            const formData = new FormData();
            for (const key in this.form) {
                const value = this.form[key];

                // Apenas adiciona se o valor não for nulo ou indefinido
                if (value !== null && value !== undefined && value !== "") {
                    if (value instanceof File || value instanceof Blob) {
                        formData.append(key, value);
                    } else if (typeof value === "boolean") {
                        formData.append(key, value ? "1" : "0"); // Laravel entende como boolean
                    } else {
                        formData.append(key, value);
                    }
                }
            }

            try {
                await fetch("/api/v1/cadastrar", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: formData,
                });

                this.$emit("corridaCadastrada");
                alert("Corrida cadastrada com sucesso!");
                this.$refs.form.reset();
            } catch (error) {
                console.error("Erro ao cadastrar corrida:", error);
                alert("Erro ao cadastrar corrida.");
            }
        },
    },
};
</script>
