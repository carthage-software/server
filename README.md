# Carthage

Carthage is a comprehensive, all-in-one application monitoring, logging, error handling, and metrics collection
solution. Utilizing Domain-Driven Design (DDD) and Hexagonal Architecture, Carthage focuses on providing a structured
and modular platform to diagnose, manage, and learn from your application's behavior, performance, and operational data.

## Bounded Contexts

Carthage is composed of several Bounded Contexts, each focusing on a specific domain. These contexts are isolated from
each other to prevent coupling and ensure that the system remains modular and extensible.

| Bounded Contexts    | Domain | Application | Infrastructure | Presentation | Tests | Documentation |
|---------------------|--------|-------------|----------------|--------------|-------|---------------|
| Shared              | ✅      | ✅           | ✅              | ✅            | ✅     | ❌             |
| Log Management      | ✅      | ✅           | ✅              | ✅            | ⚠️    | ❌             |
| Metric Collection   | ✅      | ✅           | ✅              | ✅            | ⚠️    | ❌             |
| Network Monitoring  | ⚠️     | ❌           | ❌              | ❌            | ❌     | ❌             |
| Application Health  | ⚠️     | ❌           | ❌              | ❌            | ❌     | ❌             |
| Error Tracking      | ❌      | ❌           | ❌              | ❌            | ❌     | ❌             |
| Security Monitoring | ❌      | ❌           | ❌              | ❌            | ❌     | ❌             |
| System Monitoring   | ❌      | ❌           | ❌              | ❌            | ❌     | ❌             |

# License

Carthage is proprietary software and is not licensed for public use. Please contact [Saif Eddin Gmati](https://github.com/azjezz)
