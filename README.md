# Weather App + Prometheus + Grafana

PHP‑приложение, которое показывает текущую погоду в выбранном городе (через [WeatherAPI](https://www.weatherapi.com/)), упакованное в Docker.  
Для мониторинга доступности настроены Prometheus + Grafana.

Проект задуман так, чтобы его можно было развернуть «из коробки» одной командой `docker compose up`, без ручной настройки Grafana и Prometheus.

---

## Состав

**Приложение**

- `app/index.php` — простая PHP‑страница, которая:
  - берёт API‑ключ и город из переменных окружения `WEATHERAPI_KEY` и `WEATHER_CITY`;
  - ходит в `http://api.weatherapi.com/v1/current.json`;
  - показывает текущую температуру, описание погоды и локальное время.

**Инфраструктура и мониторинг**

- Docker + Docker Compose
- Prometheus — сбор метрик
- blackbox_exporter — HTTP‑проверка доступности веб‑приложения
- Grafana — дашборды и визуализация

Grafana и Prometheus настраиваются через файлы конфигурации в репозитории (provisioning), поэтому никаких ручных настроек через веб‑интерфейс делать не нужно.

---

## Предварительные требования

- Установленный Docker Desktop / Docker Engine с Docker Compose
- Учётная запись на [WeatherAPI](https://www.weatherapi.com/) и действующий API‑ключ

---

## Запуск

### 1. Клонировать репозиторий

```bash
git clone https://github.com/ВАШ_НИК/ВАШ_РЕПОЗИТОРИЙ.git
cd ВАШ_РЕПОЗИТОРИЙ
```

### 2. Создать файл .env с настройками
На основе примера:

```bash
cp .env.example .env
```

Откройте .env и укажите реальные значения:

```bash
WEATHERAPI_KEY=ВАШ_РЕАЛЬНЫЙ_API_КЛЮЧ_ОТ_WEATHERAPI
WEATHER_CITY=London
```

### 3. Запустить все сервисы

```bash
docker compose up -d --build
```

### Доступ к поднятым сервисам:

Порты заданы в docker-compose.yml. По умолчанию:

- Приложение с погодой:
`http://localhost:8080`

- Prometheus:
`http://localhost:9090`

- Grafana:
`http://localhost:3000`
Логин/пароль по умолчанию: admin / admin

###Управление контейнерами
Остановить и удалить все контейнеры проекта:

```bash
docker compose down
```

Пересобрать образы после изменений в коде:

```bash
docker compose up -d --build
```
