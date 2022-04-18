# hibrido-multisite

-- Documentação --

Criei duas Visões de Loja em ( Lojas -> Configurações -> Todas as Lojas )

Em ( Lojas -> Configurações -> Configuração ) é possível selecionar o 'Escopo' da Visão de Loja e editar para cada uma separadamente, adicionei dois idiomas uma Visão de Loja será em inglês e a outra em português. No Escopo 'Configuração Padrão' eu configurei em ( Geral -> Web -> Opções de Url -> Adicionar o Código  da Loja aos Url's = Sim ), para que o código de cada Visão de Loja que eu criei fique na URL, no caso eu coloquei o código 'en' para versão em inglês e 'pt' para versão em português

Adicionei uma nova página 'Sobre Nós' e criei a Chave URL (identificador) e nessa página eu defino se ela será usada em uma Visão de Loja específica ou multiplas lojas. 

Criei um layout com o nome 'cms_page_view_selectable_sobrenos_custom.xml' onde 'sobrenos' é o identificador, nas configurações da Página Sobre Nós em ( Design -> Custom Layout Update ) eu seleciono esse layout para a página, assim posso definir o Block e o Template e adicionar no layout o <referenceBlock name="head.additional"> para que o link seja adicionado na HEAD.

No Block do módulo eu criei alguns métodos que eu chamo no template. Primeiro chamo o método isMultipleStore() para retornar se a página CMS Sobre Nós é usada em multiplas Visões de Loja, se 'Sim' eu adiciono a metatag chamando cada parâmetro 'hreflang' onde será o idioma, a URL da Visão de Loja que foi solicitada, e o identificador que é a página 'Sobre Nós'.
