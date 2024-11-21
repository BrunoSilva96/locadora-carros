<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
            <!-- Início do card de busca -->
            <card-component titulo="Busca de marcas">
              <template v-slot:conteudo>
                <div class="row">
                  <div class="col mb-3">
                    <input-container-component titulo="ID" id="inputId"idHelp="idHelp"texto-ajuda="Opcional. Informe o Id da marca.">
                      <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                    </input-container-component>

                  </div>
                  <div class="col mb-3">
                    <input-container-component titulo="Nome da marca" id="inputNome"idHelp="nomeHelp"texto-ajuda="Opcional. Informe o Nome da marca.">
                      <input type="text" class="form-control"Nome="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                    </input-container-component>
                  </div>
                </div>
              </template>  
              <template v-slot:rodape>
                <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
              </template>
            </card-component>
              
            <!-- Fim do card de busca -->

            <!-- Início do card de listagem de marcas -->
            <card-component titulo="Relação de marcas">
              <template v-slot:conteudo>
                <table-component></table-component>
              </template>
              <template v-slot:rodape>
                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
              </template>
            </card-component>  
            <!-- Fim do card de listagem de marcas -->
          </div>
      </div>
      <modal-component id="modalMarca" titulo="Adicionar marca">

        <template v-slot:alertas> 
          <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso!" v-if="transacaoStatus == 'adicionado'"></alert-component>
          <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca!" v-if="transacaoStatus == 'erro'"></alert-component>
        </template>

        <template v-slot:conteudo>
          <div class="form-group">
              <input-container-component titulo="Nome" id="novoNome"idHelp="novoNomeHelp"texto-ajuda="Informe o Nome da marca.">
                <input type="text" class="form-control"Nome="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca" v-model="nomeMarca">
              </input-container-component>
          </div>
          <div class="form-group">
              <input-container-component titulo="Imagem" id="novoImagem"idHelp="novoImagemHelp"texto-ajuda="Selecione uma imagem no formato PNG.">
                <input type="file" class="form-control"Nome="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
              </input-container-component>
          </div>
        </template>
        <template v-slot:rodape>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" @click="salvar">Salvar</button>
        </template>
      </modal-component>
  </div>
</template>

<script>
import axios from 'axios';

  export default {
    computed: {
        token(){
          let token = document.cookie.split(';').find(index => {
            
            return index.includes('token=');
          })
          
          token = token.split('=')[1];
          token = 'Bearer ' + token;

          return token
        }
      },
    data() {
      return {
        urlBase: 'http://127.0.0.1:8000/api/v1/marca',
        nomeMarca: '',
        arquivoImagem: [],
        transacaoStatus: '',
        transacaoDetalhes: {}
      }
    },
    methods: {
      carregarImagem(e) {
        this.arquivoImagem = e.target.files
      },
      salvar() {
        let formData = new FormData();
        formData.append('nome', this.nomeMarca)
        formData.append('imagem', this.arquivoImagem[0])

        let config = {
          headers: {
            'Content-Type': 'multipart/form-data',
            'Accept': 'application/json',
            'Authorization': this.token
          }
        }

        axios.post(this.urlBase, formData, config)
          .then(response => {
            this.transacaoStatus = 'adicionado'
            this.transacaoDetalhes = {
              mensagem: 'ID do registro: ' + response.data.id
            }
            console.log(response);
          })
          .catch(errors => {
            this.transacaoStatus = 'erro'
            this.transacaoDetalhes = {
              mensagem: errors.response.data.message,
              dados: errors.response.data.errors
            }
            console.log(errors.response.data.message);
          })
      }
    }
  }
</script>