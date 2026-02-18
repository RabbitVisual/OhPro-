# Oh Pro!

<div align="center">

<img src="storage/app/public/logo/logo.svg" alt="Oh Pro!" width="160" />

**Caderno digital do professor — profissional, leve e acolhedor.**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.1-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire)](https://livewire.laravel.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js)](https://alpinejs.dev)

</div>

---

## Sobre o nome Oh Pro!

**Oh Pro!** é uma analogia carinhosa ao jeito como o aluno chama a professora: *"Oh Pro, a senhora me ajuda nisso?"*, *"Oh Pro, eu não sei isso!"*. A plataforma quer passar essa **leveza e proximidade** para o professor: um sistema **profissional** que ao mesmo tempo **acolhe** e facilita o dia a dia. Não é só mais um software — é o caderno digital que fala a língua da sala de aula.

---

## Sobre o projeto

**Oh Pro!** é uma plataforma SaaS voltada a **professores brasileiros**, pensada para substituir o caderno de papel e a burocracia manual por um fluxo digital integrado:

- **Workspace:** escolas e turmas em um só lugar; troca de escola com um clique.
- **Planning:** planos de aula com templates; vínculo de planos às turmas.
- **Notebook:** planilha de notas (Av1, Av2, Av3, média com pesos) com autosave; chamada rápida em cards (presente/ausente).
- **Diary:** diário de classe digital; “Iniciar aula” puxa o plano aplicado; assinatura digital para finalizar e atender à exigência legal.
- **Dashboard do professor:** widget “Sua Próxima Aula” com ações rápidas (Iniciar Aula, Fazer Chamada, Ver Plano).

A arquitetura prioriza **Local-First**: fontes, ícones e scripts servidos localmente, sem depender de CDNs, adequada a hospedagem compartilhada sem abrir mão de uma UI moderna e reativa.

---

## Stack tecnológica

| Camada        | Tecnologia |
|---------------|------------|
| Backend       | [Laravel 12.x](https://laravel.com) |
| Arquitetura   | [nwidart/laravel-modules](https://nwidart.com/laravel-modules) |
| Frontend      | [Livewire 3.x](https://livewire.laravel.com) + [Alpine.js](https://alpinejs.dev) |
| Estilização   | [Tailwind CSS v4.1](https://tailwindcss.com) (CSS-first) |
| Build         | [Vite](https://vitejs.dev) |
| Ícones        | FontAwesome Pro (Duotone) |
| Banco de dados| MySQL |

- **Local-First:** fontes, ícones (FontAwesome Pro) e assets servidos localmente.
- **Dark mode:** via variáveis CSS e Tailwind v4.
- **Auditoria:** trait `Auditable` (created_by, updated_by, deleted_by) e escopo `BelongsToUser` onde aplicável.

---

## Módulos do sistema

| Módulo      | Responsabilidade |
|------------|-------------------|
| **Core**   | Componentes globais, layouts base, trait Auditable. |
| **HomePage** | Landing page, navbar, hero, benefícios, CTA, footer; rotas públicas. |
| **Workspace** | Escolas e turmas; dashboard por escola; vista da turma; widget “Sua Próxima Aula”; botão Iniciar Aula. |
| **Planning** | Planos de aula (CRUD), templates, conteúdos; vínculo com turmas (pivot). |
| **Notebook** | Planilha de notas (GradeSpreadsheet), chamada rápida (QuickAttendance); GradeService com média ponderada. |
| **Diary**  | Diário de classe; ClassDiaryService (sync do plano ao lançar aula); assinatura; finalização com signed_at. |
| **Teacher** | Rotas e painel do perfil professor (role teacher). |
| **Admin**  | Painel administrativo (role admin). |
| **Library** | Conteúdos e materiais (marketplace). |
| **Billing** | Assinaturas e pagamentos. |
| **Support** | Tickets e suporte. |

---

## Instalação

### Requisitos

- PHP 8.2+
- Composer
- Node.js 18+ e npm
- MySQL 8+

### Passos

1. **Clonar e entrar no projeto**
   ```bash
   git clone https://github.com/RabbitVisual/OhPro-.git
   cd vertex-oh-pro
   ```

2. **Dependências PHP e JS**
   ```bash
   composer install
   npm install
   ```

3. **Ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Ajuste no `.env`: `APP_NAME=Oh Pro!`, banco MySQL, etc.

4. **Banco de dados**
   ```bash
   php artisan migrate --seed
   ```

5. **Assets**
   - Desenvolvimento: `npm run dev`
   - Produção: `npm run build`

6. **Link do storage (logos, etc.)**
   ```bash
   php artisan storage:link
   ```

---

## Uso rápido (professor)

1. Acesse com usuário com role `teacher`.
2. **Workspace:** escolha a escola e abra uma turma.
3. **Planning:** crie um plano de aula e vincule à turma (aplicar).
4. Na turma: **Iniciar Aula** (cria registro no diário a partir do plano), **Chamada** (Notebook), **Notas** (Notebook).
5. No diário: preencha se precisar e **finalize com assinatura** para cumprir a exigência.

---

## Autor e créditos

<div align="center">

<img src="storage/app/public/copy/reinanrodrigues.jpg" alt="Reinan Rodrigues" width="120" style="border-radius: 50%;" />

**Reinan Rodrigues** — Full Stack Developer & Architect

<img src="storage/app/public/copy/vertexsolutions.png" alt="Vertex Solutions LTDA" width="200" />

Desenvolvido por **Vertex Solutions LTDA**  
© 2026 Vertex Solutions LTDA. Todos os direitos reservados.

</div>
