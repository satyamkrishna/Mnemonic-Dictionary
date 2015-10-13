from django.db import models

# Create your models here.
class Word(models.Model):
    id   = models.AutoField(primary_key = True, db_column = 'wordID')
    name = models.CharField(db_column = 'word', max_length = 50)

    def __str__(self):
        return self.name

    class Meta:
        db_table = "word_list"
