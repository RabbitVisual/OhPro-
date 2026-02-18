# Módulos Oh Pro!

O projeto **Oh Pro!** usa [nwidart/laravel-modules](https://nwidart.com/laravel-modules). Cada módulo fica em `Modules/<NomeDoModulo>/` e segue o padrão da **Vertex Solutions LTDA**.

## Módulos ativos

| Módulo     | Descrição resumida |
|-----------|---------------------|
| **Core**  | Traits (Auditable), layouts base, componentes compartilhados. |
| **HomePage** | Landing (hero, benefícios, CTA), navbar, footer, rotas públicas. |
| **Workspace** | Escolas e turmas; dashboard; vista da turma; Next Class widget. |
| **Planning** | Planos de aula, templates, vínculo com turmas. |
| **Notebook** | Notas (GradeSpreadsheet), chamada (QuickAttendance). |
| **Diary** | Diário de classe, Launch Class, assinatura, finalização. |
| **Teacher** | Rotas e painel do professor. |
| **Admin**  | Painel administrativo. |
| **Library** | Conteúdos e materiais. |
| **Billing** | Assinaturas e pagamentos. |
| **Support** | Suporte e tickets. |

## Criar um novo módulo

```bash
php artisan module:make NomeDoModulo
```

O módulo é criado em `Modules/NomeDoModulo/` com:

- `module.json` — nome, alias, descrição, versão, autor, providers
- `ServiceProvider` — PathNamespace, views, config, migrations, traduções
- `RouteServiceProvider` e `EventServiceProvider`
- `routes/web.php` e `routes/api.php`
- Layout master e views padrão

## Ativar / desativar

O status é controlado em `modules_statuses.json`:

```bash
php artisan module:enable NomeDoModulo
php artisan module:disable NomeDoModulo
```

## Stubs

Stubs customizados em `stubs/nwidart-stubs/`. Configuração em `config/modules.php`.

## Convenções

- **Views:** `Modules/<Nome>/resources/views/`; namespace de views `nomemodulo::`.
- **Rotas:** carregadas pelo `RouteServiceProvider` do módulo (prefixos e nomes conforme cada módulo).
- **Livewire:** componentes registrados no `ServiceProvider` do módulo com `Livewire::component()`.
- **Migrations:** o módulo pode carregar migrações em `database/migrations` via `loadMigrationsFrom()`.
