<?php
	namespace Library\Models;
	use \Library\Models\Comment;
	
    class CommentsManager_PDO extends CommentsManager
    {
        protected function add(Comment $comment)
        {
            $q = $this->dao->prepare('INSERT INTO comments SET news = :news, auteur = :auteur, contenu = :contenu, date = NOW()');
            
            $q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
            $q->bindValue(':auteur', $comment->auteur());
            $q->bindValue(':contenu', $comment->contenu());
            
            $q->execute();
            
            $comment->setId($this->dao->lastInsertId());
        }
        
        public function delete($id)
        {
            $this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
        }
        
        protected function modify(Comment $comment)
        {
            $q = $this->dao->prepare('UPDATE comments SET auteur = :auteur, contenu = :contenu WHERE id = :id');
            
            $q->bindValue(':auteur', $comment->auteur());
            $q->bindValue(':contenu', $comment->contenu());
            $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
            
            $q->execute();
        }
        
        public function getListOf($news)
        {
            if (!is_int($news))
            {
                throw new InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
            }
            
            $q = $this->dao->prepare('SELECT id, news, auteur, contenu, DATE_FORMAT(date, \'le %d/%m/%Y à %Hh%i\') AS date FROM comments WHERE news = :news');
            $q->bindValue(':news', $news, \PDO::PARAM_INT);
            $q->execute();
            
            $comments = array();
            
            while ($data = $q->fetch(\PDO::FETCH_ASSOC))
            {
                $comments[] = new Comment($data);
            }
            
            return $comments;
        }
        
        public function get($id)
        {
            $q = $this->dao->prepare('SELECT id, news, auteur, contenu FROM comments WHERE id = :id');
            $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
            $q->execute();
            
            return new Comment($q->fetch(\PDO::FETCH_ASSOC));
        }
    } 
