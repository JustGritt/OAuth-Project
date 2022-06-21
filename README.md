# OAuth-Project

![License](https://img.shields.io/static/v1?label=license&message=MIT&color=green) ![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/JustGritt/OAuth-Project) ![GitHub commit activity](https://img.shields.io/github/commit-activity/m/JustGritt/OAuth-Project)

> <br>[OAuth-Project](#oauth-project) is a school project in which we were asked to develop an SDK and connect to multiple OAuth 2.0 providers. There are two mandatory public providers to use:
-> [Google provider](https://developers.google.com/identity/protocols/OpenIDConnect) & [Facebook provider](https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow)
-> The OAuth server provider created during the class (which is a Discord variant)
> <br>

## Table of Contents

1. **Getting Started**
    - [What is OAuth-Project ?](#oauth-project)
    <br>
2. **Download & Prerequisites**
    - [Prerequisites](#prerequisites)
    <br>
3. **License**
    - [MIT](#license)
    <br>

## Prerequisites

**Installing Docker**

Make sure that you have a recent version of [Docker](https://www.docker.com/get-started/) on your machine, as it is a requirement to run this project.

Depending on your installation you may have both [Docker](https://www.docker.com/get-started/) and [Docker Compose](https://docs.docker.com/compose/) available, you can check if either is on your machine by running the commands below.
<br>

**You may check your Docker & Docker-compose version by running**:

```bash
docker --version
docker-compose --version
```
<br>

**Building project**

```bash
docker-compose up -d
```
<br>


**How to add a new provider**

To add a new provider to the project, you have to execute the following actions: 

```bash
docker-compose exec php php artisan oauth:add-provider --provider=<provider_name>
```