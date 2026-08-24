# Security policy — Zinn Cache Pro

## Reporting a vulnerability

Report security issues in **Zinn® Cache Pro** to **security@zinndigital.com**.

Please include the plugin version, the WordPress and PHP versions, and enough detail to
reproduce. We aim to acknowledge within two working days.

Please do **not** open a public issue for a security report, and please do **not** report issues
with this plugin to LiteSpeed Technologies — Zinn® Cache Pro is an independent fork and they do
not support it.

## If the issue is inherited from upstream

Zinn® Cache Pro is a fork of LiteSpeed Cache (see `CHANGES-FROM-UPSTREAM.md`). If a report turns
out to affect upstream too, we will coordinate disclosure with LiteSpeed Technologies at
<https://www.litespeedtech.com/report-security-bugs> so the fix reaches their users as well as
ours. Tell us if you would prefer to report to them directly first; either order is fine, we
only want to avoid a silent one-sided fix.

## Scope

In scope: anything in this plugin that lets an unauthorised party read or change data, escalate
privileges, execute code, or poison cached output for other visitors.

Out of scope: findings that require an administrator to already be compromised; the deliberate
absence of the QUIC.cloud integration and its features; and reports against upstream LiteSpeed
Cache that do not apply to this fork.
