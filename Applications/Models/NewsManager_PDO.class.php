<?php
	namespace Library\Models;
	//use \Library\Models\News;

    class NewsManager_PDO extends NewsManager
    {
        protected function add(News $news)
        {
            $requete = $this->dao->prepare('INSERT INTO news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');
            
            $requete->bindValue(':titre', $news->titre());
            $requete->bindValue(':auteur', $news->auteur());
            $requete->bindValue(':contenu', $news->contenu());
            
            $requete->execute();
        }
        
        public function delete($id)
        {
            $this->dao->exec('DELETE FROM news WHERE id = '.(int) $id);
        }
        
        protected function modify(News $news)
        {
            $requete = $this->dao->prepare('UPDATE news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');
            
            $requete->bindValue(':titre', $news->titre());
            $requete->bindValue(':auteur', $news->auteur());
            $requete->bindValue(':contenu', $news->contenu());
            $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);
            
            $requete->execute();
        }
        
        public function count()
        {
            return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
        }
        
        public function getList($debut = -1, $limite = -1)
        {
            $listeNews = array();
            
            $sql = 'SELECT id, auteur, titre, contenu, DATE_FORMAT (dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout, DATE_FORMAT (dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif FROM news ORDER BY id DESC';
            
            if ($debut != -1 || $limite != -1)
            {
                $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
            }
            
            $requete = $this->dao->query($sql);
            
            while ($news = $requete->fetch(\PDO::FETCH_ASSOC))
            {
                $listeNews[] = new News($news);
            }
            
            $requete->closeCursor();
            
            return $listeNews;
        }
        
        public function getUnique($id)
        {
            $requete = $this->dao->prepare('SELECT id, auteur, titre, contenu, DATE_FORMAT (dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout, DATE_FORMAT (dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif FROM news WHERE id = :id');
            $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
            $requete->execute();
            
            if ($donnees = $requete->fetch(\PDO::FETCH_ASSOC))
            {
                return new News($donnees);
            }
            
            return null;
        }
    } 
