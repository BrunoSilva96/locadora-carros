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
        <template v-slot:conteudo>
          <div class="form-group">
              <input-container-component titulo="Nome" id="novoNome"idHelp="novoNomeHelp"texto-ajuda="Informe o Nome da marca.">
                <input type="text" class="form-control"Nome="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca">
              </input-container-component>
          </div>
          <div class="form-group">
              <input-container-component titulo="Imagem" id="novoImagem"idHelp="novoImagemHelp"texto-ajuda="Selecione uma imagem no formato PNG.">
                <input type="file" class="form-control"Nome="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem">
              </input-container-component>
          </div>
        </template>
        <template v-slot:rodape>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary">Salvar</button>
        </template>
      </modal-component>
  </div>
</template>

<script>
</script>