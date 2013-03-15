-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2013 at 07:15 PM
-- Server version: 5.0.95
-- PHP Version: 5.1.6
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

 --
-- Database: `Avaluo`
--
 --
-- Dumping data for table `NombresRubricas`
--

INSERT INTO `NombresRubricas` (`rub_id`, `nombre_rub`)
VALUES (1,
        'RÃºbrica para evaluar ensayos'), (2,
                                           'RÃºbrica para informes orales'), (3,
                                                                              'Rubrica para informe tÃ©cnico'), (4,
                                                                                                                 'Rubrica Personal'), (5,
                                                                                                                       'RÃºbrica para presentaciÃ³n de afiche');

 --
-- Dumping data for table `NombresRubricasLocal`
--

INSERT INTO `NombresRubricasLocal` (`rublocal_id`, `nombre_rub`)
VALUES (1,
        'RÃºbrica para evaluar ensayos'), (2,
                                           'RÃºbrica para informes orales'), (3,
                                                                              'Rubrica para informe tÃ©cnico'), (4,
                                                                                                                 'Rubrica Personal'), (5,
                                                                                                                       'RÃºbrica para presentaciÃ³n de afiche');
 --
-- Dumping data for table `Criterios`
--

INSERT INTO `Criterios` (`crit_id`, `nombre_crit`)
VALUES (1,
        'claridad'), (2,
                      'organizaciÃ³n'), (3,
                                         'comunicaciÃ³n de ideas'), (4,
                                                                     'correcciÃ³n');

 --
-- Dumping data for table `Cursos`
--

INSERT INTO `Cursos` (`curso_id`, `codificacion`, `seccion`, `nombre_curso`, `fac_curso`, `prog_curso`)
VALUES (1,
        'CCOM3020',
        'OU1',
        'Discreta',
        'CNAT',
        'Ciencia de Computos'), (2,
                                 'MATE4995',
                                 'OU1',
                                 'Web Development',
                                 'CNAT',
                                 'Ciencia de Computos'), (3,
                                       'CCOM9999',
                                       '0U1',
                                       'Compiladores',
                                       'CNAT',
                                       'Ciencia de Computos');

 --
-- Dumping data for table `Dominios`
--

INSERT INTO `Dominios` (`dom_id`, `nombre_dom`, `valor_esperado`)
VALUES (1,
        'comunicaciÃ³n efectiva',
        70);

 --
-- Dumping data for table `EscalaCriterio`
--

INSERT INTO `EscalaCriterio` (`crit_id`, `valor`, `descripcion`)
VALUES (1,
        6,
        'La redacciÃ³n comunica la idea central clara y efectivamente.'), (1,
                                                                           4,
                                                                           'La redacciÃ³n es confusa  en ocasiones, por lo que dificulta levemente la comprensiÃ³n de la idea central.'), (1,
                                                                                                                                                                                           2,
                                                                                                                                                                                           'La redacciÃ³n es confusa, por lo que continuamente dificulta la comprensiÃ³n de idea central.'), (2,
                                                                                                                                                                                                                                                                                              6,
                                                                                                                                                                                                                                                                                              'La organizaciÃ³n y estructura del trabajo comunican efectiva y coherentemente los argumentos. Las transiciones/relaciones entre las ideas son presentadas de forma correcta.'), (2,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                4,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'La organizaciÃ³n y estructura del trabajo permiten parcialmente la comunicaciÃ³n efectiva y coherente de los argumentos. En ocasiones, las transiciones/relaciones entre las ideas no son presentadas de forma correcta.'), (2,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              2,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              'La organizaciÃ³n y estructura del trabajo no permiten la comunicaciÃ³n efectiva y coherente de los argumentos. La transiciones/relaciones entre las ideas son presentadas de forma incorrecta.'), (3,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  6,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  'El nivel acÃ¡demico y preciso de la lengua corresponde a la tarea y ayuda a la comunicaciÃ³n efectiva de las ideas a travÃ©s del trabajo.'), (3,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 4,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 'El nivel de lengua es desigual; se mezcla la precisiÃ³n con lo banal lo acadÃ©mico con lo coloquial a travÃ©s del trabajo.'), (3,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 2,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 'El nivel de lengua no es acadÃ©mico o preciso. A travÃ©s del trabajo abundan las imprecisiones, la repeticiÃ³n y el lenguaje coloquial.'), (4,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              6,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              'La ortografÃ­a y la correcciÃ³n gramatical son en su mayorÃ­a precisas y correctas, por lo que promueven la lectura del trabajo y la comprensiÃ³n de las ideas.'), (4,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   4,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   'La ortografÃ­a y la correcciÃ³n gramatical son en ocasiones incorrectas, pero no interfieren en  la lectura del trabajo y en la comprensiÃ³n de las ideas.'), (4,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   2,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   'La ortografÃ­a y la correcciÃ³n gramatical son imprecisas e incorrectas, por lo que continuamente interfieren en la lectura del trabajo y en  la comprensiÃ³n de las ideas.'), (1,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    8,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    'Usted es un genio. Tenga su diploma.'), (2,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              8,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              'Acaba de sacar 7 u 8 en una escala que llega hasta 6.'), (3,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         8,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         'Oh, cuanta sapiencia!'), (4,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    8,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    'Nos gusta ponernos graciosos a la hora de inventar escalas.');

 --
-- Dumping data for table `Profesores`
--

INSERT INTO `Profesores` (`prof_id`, `nombre_prof`, `email`, `passwd`, `dpto_prof`, `fac_prof`)
VALUES (1,
        'Carlos Corrada',
        'ccorrada@upr.edu',
        '497ae86f83514d8ca7cfce5f171bc977',
        'Ciencia de CÃ³mputos',
        'CNAT'), (2,
                  'Jose Ortiz',
                  'cheo@hpcf.com',
                  'a152e841783914146e4bcd4f39100686',
                  'CCOM',
                  'CNAT'),(3,
                            'Administrador',
                            'oeae.uprrp@upr.edu',
                            '7d6030f0e2f2c56b609c4c4721b1f5a4',
                            NULL,
                            NULL);

 --
-- Dumping data for table `ProfesorImparte`
--

INSERT INTO `ProfesorImparte` (`prof_id`, `curso_id`)
VALUES (1,
        1), (1,
             2), (2,
                  3);

 --
-- Dumping data for table `Estudiantes`
--

INSERT INTO `Estudiantes` (`est_id`, `nombre_est`, `no_est`)
VALUES (1,
        'Tahiri Laboy',
        '842074037'), (2,
                       'Christian Rodriguez',
                       '801110001'), (3,
                                      'Alex Santos',
                                      '801112222'), (4,
                                                     'Jose Reyes',
                                                     '801093333'), (5,
                                                                    'Felipe Torres',
                                                                    '801086969');

 --
-- Dumping data for table `Actividades`
--

INSERT INTO `Actividades` (`act_id`, `nombre_act`, `logro_esperado`, `fecha_dado`, `ultima_modif`, `rublocal_id`, `estudiantes_logro`)
VALUES (1,
        'Tarea Programacion',
        70,
        NULL,
        '2013-03-08 23:44:53',
        1,70), (10,
             'Examen1',
             70,
             NULL,
             '2013-03-08 23:23:43',
             3,70), (11,
                  'otra',
                  45,
                  NULL,
                  '2013-03-08 23:43:24',
                  2,70), (12,
                       'Examen2',
                       50,
                       NULL,
                       '2013-03-10 14:00:36',
                       3,70), (13,
                            'Tarea1',
                            50,
                            NULL,
                            '2013-03-10 18:56:07',
                            3,70), (14,
                                 'proyecto',
                                 80,
                                 NULL,
                                 '2013-03-11 08:56:37',
                                 1,70), (15,
                                      'proyecto',
                                      95,
                                      NULL,
                                      '2013-03-11 08:58:29',
                                      2,70), (16,
                                           'EL Examen',
                                           1,
                                           NULL,
                                           '2013-03-11 10:37:27',
                                           1,70), (17,
                                                'practica',
                                                50,
                                                NULL,
                                                '2013-03-12 11:46:00',
                                                1,70);

 --
-- Dumping data for table `ActividadesCurso`
--

INSERT INTO `ActividadesCurso` (`act_id`, `curso_id`)
VALUES (1,
        1), (10,
             1), (17,
                  2), (16,
                       1), (14,
                            2), (14,
                                 1), (13,
                                      3), (12,
                                           1), (11,
                                                2);

 --
-- Dumping data for table `CriterioPertenece`
--

INSERT INTO `CriterioPertenece` (`dom_id`, `crit_id`)
VALUES (1,
        1), (1,
             2), (1,
                  3), (1,
                       4);

 --
-- Dumping data for table `Matricula`
--

INSERT INTO `Matricula` (`curso_id`, `est_id`, `mat_id`)
VALUES (1,
        1,
        1), (1,
             2,
             2), (1,
                  3,
                  3), (1,
                       4,
                       4), (3,
                            1,
                            6);

 --
-- Dumping data for table `Evaluacion`
--

INSERT INTO `Evaluacion` (`act_id`, `crit_id`, `ptos_obtenidos`, `mat_id`)
VALUES (1,
        1,
        7,
        1), (1,
             1,
             8,
             2), (1,
                  2,
                  8,
                  1), (1,
                       2,
                       0,
                       2), (1,
                            2,
                            0,
                            3), (1,
                                 2,
                                 0,
                                 4), (1,
                                      3,
                                      8,
                                      1), (1,
                                           3,
                                           0,
                                           2), (1,
                                                3,
                                                0,
                                                3), (1,
                                                     3,
                                                     0,
                                                     4), (1,
                                                          4,
                                                          8,
                                                          1), (1,
                                                               4,
                                                               0,
                                                               2), (1,
                                                                    4,
                                                                    0,
                                                                    3), (1,
                                                                         4,
                                                                         0,
                                                                         4), (10,
                                                                              1,
                                                                              6,
                                                                              1), (10,
                                                                                   1,
                                                                                   8,
                                                                                   2), (10,
                                                                                        1,
                                                                                        5,
                                                                                        3), (10,
                                                                                             1,
                                                                                             8,
                                                                                             4), (12,
                                                                                                  1,
                                                                                                  2,
                                                                                                  2), (12,
                                                                                                       1,
                                                                                                       7,
                                                                                                       3), (13,
                                                                                                            1,
                                                                                                            5,
                                                                                                            6);

 --
-- Dumping data for table `RubricaCreadaPor`
--

INSERT INTO `RubricaCreadaPor` (`prof_id`, `rub_id`)
VALUES (1,
        1);

 --
-- Dumping data for table `RubricaLocal`
--

INSERT INTO `RubricaLocal` (`rublocal_id`, `crit_id`, `prof_id`)
VALUES (2,
        1,
        1), (2,
             3,
             1), (2,
                  4,
                  1), (3,
                       1,
                       1), (3,
                            2,
                            1), (1,
                                 3,
                                 1), (1,
                                      4,
                                      1), (3,
                                           3,
                                           1), (4,
                                                1,
                                                1), (4,
                                                     4,
                                                     1),(1,
                                                         1,
                                                         1);

 --
-- Dumping data for table `Rubricas`
--

INSERT INTO `Rubricas` (`rub_id`, `crit_id`)
VALUES (2,
        1), (2,
             3), (2,
                  4), (3,
                       1), (3,
                            2), (1,
                                 3), (1,
                                      4), (3,
                                           3), (4,
                                                1), (4,
                                                     4),(1,
                                                         1);

