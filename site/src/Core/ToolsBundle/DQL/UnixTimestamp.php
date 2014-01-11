<?php

namespace Core\ToolsBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;

/**
 * Description of UnixTimestamp
 *
 * @author Boris
 */
class UnixTimestamp extends FunctionNode
{
    public $firstDateExpression = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstDateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'UNIX_TIMESTAMP(' . $this->firstDateExpression->dispatch($sqlWalker) . ')';
    }
}

?>
