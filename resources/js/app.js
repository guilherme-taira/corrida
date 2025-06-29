import './bootstrap';
import { createApp } from 'vue';

// Vuetify
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css'

import router from './router'; // importa o roteador

// Criando o Vuetify
const vuetify = createVuetify({
    components,
    directives,
});

// Criando a aplicação Vue
import App from './App.vue';
const app = createApp(App);

// Componentes
import ExampleComponent from './components/ExampleComponent.vue';
import RankingTable from './components/RankingTable.vue';
import Eventos from './components/Eventos.vue';

app.component('eventos', Eventos);
app.component('example-component', ExampleComponent);
app.component('ranking-table', RankingTable);

// Use Vuetify e Vue Router
app.use(vuetify);
app.use(router);

// Montar a aplicação
app.mount('#app');
