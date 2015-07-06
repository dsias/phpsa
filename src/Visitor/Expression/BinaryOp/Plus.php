<?php

namespace PHPSA\Visitor\Expression\BinaryOp;

use PHPSA\CompiledExpression;
use PHPSA\Context;
use PHPSA\Visitor\Expression;
use PHPSA\Visitor\Expression\AbstractExpressionCompiler;

class Plus extends AbstractExpressionCompiler
{
    protected $name = '\PhpParser\Node\Expr\BinaryOp\Plus';

    /**
     * {expr} + {expr}
     *
     * @param \PhpParser\Node\Expr\BinaryOp\Plus $expr
     * @param Context $context
     * @return CompiledExpression
     */
    public function compile($expr, Context $context)
    {
        $expression = new Expression($context);
        $left = $expression->compile($expr->left);

        $expression = new Expression($context);
        $right = $expression->compile($expr->right);

        switch ($left->getType()) {
            case CompiledExpression::LNUMBER:
                switch ($right->getType()) {
                    case CompiledExpression::LNUMBER:
                        /**
                         * php -r "var_dump(1 + 1);" int(2)
                         */
                        return new CompiledExpression(CompiledExpression::LNUMBER, $left->getValue() + $right->getValue());
                    case CompiledExpression::DNUMBER:
                        /**
                         * php -r "var_dump(1 + 1.0);" double(2)
                         */
                        return new CompiledExpression(CompiledExpression::DNUMBER, $left->getValue() + $right->getValue());
                }
                break;
            case CompiledExpression::DNUMBER:
                switch ($right->getType()) {
                    case CompiledExpression::LNUMBER:
                    case CompiledExpression::DNUMBER:
                        /**
                         * php -r "var_dump(1.0 + 1);"   double(2)
                         * php -r "var_dump(1.0 + 1.0);" double(2)
                         */
                        return new CompiledExpression(CompiledExpression::DNUMBER, $left->getValue() + $right->getValue());
                }
                break;
        }

        return new CompiledExpression(CompiledExpression::UNKNOWN);
    }
}
