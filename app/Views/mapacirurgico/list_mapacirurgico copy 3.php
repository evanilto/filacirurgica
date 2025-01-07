<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de DataTable com Cabeçalho Fixo</title>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.4/css/fixedColumns.dataTables.min.css">
</head>

<style>
    .dataTables_wrapper {
    overflow: auto;
}

</style>

<body>
    <div class="container mt-5">
        <table id="table" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Coluna 1</th>
                    <th>Coluna 2</th>
                    <th>Coluna 3</th>
                    <th>Coluna 4</th>
                    <th>Coluna 5</th>
                    <th>Coluna 6</th>
                    <th>Coluna 7</th>
                    <th>Coluna 8</th>
                    <th>Coluna 9</th>
                    <th>Coluna 10</th>
                    <th>Coluna 11</th>
                    <th>Coluna 12</th>
                    <th>Coluna 13</th>
                    <th>Coluna 14</th>
                    <th>Coluna 15</th>
                    <th>Coluna 16</th>
                    <th>Coluna 1</th>
                    <th>Coluna 2</th>
                    <th>Coluna 3</th>
                    <th>Coluna 4</th>
                    <th>Coluna 5</th>
                    <th>Coluna 6</th>
                    <th>Coluna 7</th>
                    <th>Coluna 8</th>
                    <th>Coluna 9</th>
                    <th>Coluna 10</th>
                    <th>Coluna 11</th>
                    <th>Coluna 12</th>
                    <th>Coluna 13</th>
                    <th>Coluna 14</th>
                    <th>Coluna 15</th>
                    <th>Coluna 16</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                <tr>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                    <td>Dados 1.1</td>
                    <td>Dados 1.2</td>
                    <td>Dados 1.3</td>
                    <td>Dados 1.4</td>
                    <td>Dados 1.5</td>
                    <td>Dados 1.6</td>
                    <td>Dados 1.7</td>
                    <td>Dados 1.8</td>
                    <td>Dados 1.9</td>
                    <td>Dados 1.10</td>
                    <td>Dados 1.11</td>
                    <td>Dados 1.12</td>
                    <td>Dados 1.13</td>
                    <td>Dados 1.14</td>
                    <td>Dados 1.15</td>
                    <td>Dados 1.16</td>
                </tr>
                
            </tbody>
        </table>
    </div>

<!-- Scripts JavaScript para DataTables e seus plugins -->
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.4/js/dataTables.fixedColumns.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                fixedHeader: true,
                scrollY: '400px',
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                ordering: true,
                autoWidth: true,
                fixedColumns: {
                    leftColumns: 1
                }
            });
        });
    </script>
    
</body>
</html>
