delete from imovel where idimovel in (2336);
--
delete from tipo_imovel where idtipo_imovel in (2);
--
delete from setor where idsetor in (2212)
--
delete from cidade where idcidade in (2174)
--
insert into imovel(idimovel,codigo_sistema,descricao,endereco,complemento,idtipo_imovel,quarto,suite,sala_total,venda_aluguel,idsetor,idcidade,valor_venda,valor_aluguel,valor_condominio,contador,garagem_total,area_util,area_terreno,destaque)values(2336,2336,'Venda - Casa 3 quartos, sala p/2 ambientes, cozinha c/armários, área de serviço, garagem. CJ10050 F.4008-8844 L2336 ','Rua Coritiba Qd.15 Lt.06','',2,3,0,1,2,2212,2174,450000,0,0,7,2,170,420,1);
--

--
delete from foto where idfoto in (21019,21020,21021,21022,21023,21024,21025)/*fotos a publicar*/
--
insert into foto(idfoto, nmfoto, idimovel, descricao) values(21019,1,2336,"SDC11071")
--
insert into foto(idfoto, nmfoto, idimovel, descricao) values(21020,2,2336,"SDC11061")
--
insert into foto(idfoto, nmfoto, idimovel, descricao) values(21021,3,2336,"SDC11065")
--
insert into foto(idfoto, nmfoto, idimovel, descricao) values(21022,4,2336,"SDC11063")
--
insert into foto(idfoto, nmfoto, idimovel, descricao) values(21023,5,2336,"SDC11064")
--
insert into foto(idfoto, nmfoto, idimovel, descricao) values(21024,6,2336,"SDC11066")
--
insert into foto(idfoto, nmfoto, idimovel, descricao) values(21025,7,2336,"SDC11067")
--
insert into tipo_imovel(IDTIPO_IMOVEL, NMTIPO_IMOVEL) values(2,'Casa');
--
insert into setor(idcidade, idsetor, nmsetor) values(2174,2212,'Alto da Glória')
--
insert into cidade(idcidade, nmcidade) values(2174,'Goiânia');