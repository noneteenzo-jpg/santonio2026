# Kemel Fitness Manager

Protótipo web acadêmico de gestão interna de matrículas, desenvolvido com HTML, CSS e PHP conforme o enunciado do projeto Fitness Manager.

## Requisitos
- PHP 8.0 ou superior (recomendado PHP 8.1+ com extensão `mbstring`).
- Navegador atualizado.
- Não utiliza banco de dados: os dados são processados e exibidos no comprovante, sem persistência.

## Como executar localmente
1. Extraia a pasta `Kemel_Fitness_Manager`.
2. Abra um terminal dentro dessa pasta.
3. Execute `php -S localhost:8000`.
4. Acesse `http://localhost:8000` no navegador.
5. Clique em **Nova matrícula**, preencha os campos e gere o comprovante.

> Não abra o arquivo PHP diretamente pelo navegador ou por `file://`; execute-o através de um servidor PHP.

## Planos e descontos
| Plano | Mensalidade | Inclui |
|---|---:|---|
| Básico | R$ 89,90 | Musculação |
| Plus | R$ 129,90 | Musculação e aulas coletivas |
| Premium | R$ 179,90 | Todas as modalidades |

- PIX: 10% de desconto.
- Aluno com 60 anos ou mais: 15% de desconto.
- Os descontos não são acumulados. É aplicado somente o maior percentual elegível.
- Cartão não oferece desconto próprio, mas o desconto por idade continua válido.

Os preços estão centralizados no início de `processar.php`, no array `$planos`, para facilitar futuras alterações.

## Testes obrigatórios sugeridos
1. Cadastro válido, plano Plus, cartão: deve apresentar R$ 129,90 sem desconto.
2. Deixar um campo obrigatório vazio: o navegador impede o envio; se a validação do navegador for contornada, o PHP também rejeita.
3. Informar idade inferior a 18 anos: deve ser rejeitado.
4. Básico no cartão, idade 18–59: R$ 89,90, desconto de 0%, total R$ 89,90.
5. Premium no PIX, idade 18–59: desconto de 10% (R$ 17,99), total R$ 161,91.
6. Plus no PIX, idade 60 ou mais: desconto de 15% (R$ 19,49), total R$ 110,41. Não deve aplicar 25%.
7. Conferir se o comprovante apresenta os mesmos dados digitados no formulário.

## Arquivos
- `index.html`: painel administrativo e consulta dos planos/regras.
- `cadastro.html`: formulário de matrícula.
- `processar.php`: validação no servidor, cálculo de descontos e comprovante.
- `style.css`: identidade visual responsiva e estilos de impressão.

## Observação
O projeto não implementa autenticação real nem grava matrículas, pois o escopo do PDF define uma aplicação interna demonstrativa sem banco de dados. O aviso no comprovante deixa claro que ele não é confirmação de pagamento real.
